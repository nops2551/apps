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

angular.module('News').factory 'FeedModel', 
['Model', '$rootScope', 
(Model, $rootScope) ->

	class FeedModel extends Model

		constructor: (@$rootScope) ->
			super()
			@$rootScope.$on 'update', (scope, data) =>
				if data['feeds']
					for feed in data['feeds']
						@add(feed)


	return new FeedModel($rootScope)
]