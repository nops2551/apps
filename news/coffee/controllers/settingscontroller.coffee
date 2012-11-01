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

angular.module('News').controller 'SettingsController', 
['Controller', '$scope', 'ShowAll', '$rootScope',
(Controller, $scope, ShowAll, $rootScope) ->

	class SettingsController extends Controller

		constructor: (@$scope, @$rootScope, @showAll) ->
			
			@$scope.getShowAll = =>
				return @showAll.showAll

			@$scope.setShowAll = (value) =>
				@showAll.showAll = value
				@$rootScope.$broadcast('triggerHideRead')



	return new SettingsController($scope, $rootScope, ShowAll)
]