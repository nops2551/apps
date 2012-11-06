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
['Controller', '$scope', 'ShowAll', '$rootScope', 'PersistenceNews',
(Controller, $scope, ShowAll, $rootScope, PersistenceNews) ->

	class SettingsController extends Controller

		constructor: (@$scope, @$rootScope, @showAll, @persistence) ->
			
			@add = false
			@settings = false

			@$scope.getShowAll = =>
				return @showAll.showAll

			@$scope.setShowAll = (value) =>
				@showAll.showAll = value
				@persistence.showAll(value)
				@$rootScope.$broadcast('triggerHideRead')

			@$scope.toggleSettings = =>
				if @add
					@add = false
				@settings = !@settings

			@$scope.toggleAdd = =>
				if @settings
					@settings = false
				@add = !@add

			@$scope.isExpanded = =>
				return  @settings || @add

			@$scope.addIsShown = =>
				return @add

			@$scope.settingsAreShown = =>
				return @settings

			@$scope.addFeed = (url) =>
				console.log url
				$scope.feedUrl = ""

			@$scope.addFolder = (name) =>
				console.log name
				$scope.folderName = ""


	return new SettingsController($scope, $rootScope, ShowAll, PersistenceNews)
]