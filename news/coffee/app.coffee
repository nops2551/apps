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

app = angular.module('News', []).config ($provide) ->
	# enter your config values in here
	$provide.value('MarkReadTimeout', 500)
	$provide.value('ScrollTimeout', 500)

app.run ['$rootScope', 'PersistenceNews', ($rootScope, PersistenceNews) ->
	PersistenceNews.loadInitial()
	$rootScope.$broadcast('scrollTop')
]




