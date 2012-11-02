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

angular.module('News').factory 'StarredCount', ['$rootScope', ($rootScope) ->
	
	starredCount = 
		count: 0

	$rootScope.$on 'update', (scope, data) ->
		if data['starredCount'] != undefined
			starredCount.count = data['starredCount']

	return starredCount
]