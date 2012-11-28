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

###
# This is used to signal the settings bar that the app has been focused and that
# it should hide
###
angular.module('News').directive 'appfocus', ['$rootScope', ($rootScope) ->

	return (scope, elm, attr) ->
		elm.bind 'click', ->
			$rootScope.$broadcast('appfocus')
			scope.$apply attr.appfocus

]
