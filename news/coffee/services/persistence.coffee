###
# ownCloud - News app
#
# @author Bernhard Posselt
# Copyright (c) 2012 - Bernhard Posselt <nukeawhale@gmail.com>
#
# This file is licensed under the Affero General Public License version 3 or later.
# See the COPYING-README file
#
###

angular.module('News').factory 'Persistence', () ->

	class Persistence

		constructor: (@appName, @$http) ->


		post: (file, data={}, callback) ->
			if not callback
				callback = ->

			url = OC.filePath(@appName, 'ajax', file + '.php')

			# csrf token
			headers =
				requesttoken: OC.Request.Token
			
			@$http({method: 'POST', url: url, data: data, headers: headers}).
			success((data, status, headers, config) ->
				callback(data)
			).
			error (data, status, headers, config) ->
				console.warn('Error occured: ')
				console.warn(status)
				console.warn(headers)
				console.warn(config)

