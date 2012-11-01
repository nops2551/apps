angular.module('News').factory 'Persistence', ['$http', ($http) ->
	class Persistence

		constructor: (@$http) ->


		collapseFolder: (value) ->
			data =
				opened: value
			@post('collapsefolder', data)


		post: (file, data, callback) ->
			if not callback
				callback = ->

			url = OC.filePath('news', 'ajax', file + '.php')

			# csrf token
			headers =
				requesttoken: OC.Request.Token
			
			$http({method: 'POST', url: url, data: data, headers: headers}).
			success((data, status, headers, config) ->
				callback(data)
			).
			error (data, status, headers, config) ->
				console.warn('Error occured: ')
				console.warn(status)
				console.warn(headers)
				console.warn(config)


	return new Persistence($http)

]