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

angular.module('News').factory 'ActiveFeed',['$rootScope', ($rootScope) ->

	activeFeed = 
		id: 0
		type: 3

	$rootScope.$on 'update', (scope, data) ->
		if data['activeFeed']
			activeFeed.id = data['activeFeed'].id
			activeFeed.type = data['activeFeed'].type

	return activeFeed
]