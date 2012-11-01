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