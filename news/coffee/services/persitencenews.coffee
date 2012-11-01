angular.module('News').factory 'PersistenceNews', ['Persistence', '$http', (Persistence, $http) ->

	class PersistenceNews extends Persistence

		constructor: ($http) ->
			super('news', $http)


		collapseFolder: (folderId, value) ->
			data =
				folderId: folderId
				opened: value
			@post('collapsefolder', data)


	return new PersistenceNews($http)
]