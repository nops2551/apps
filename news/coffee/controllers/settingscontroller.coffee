angular.module('News').controller 'SettingsController', 
['Controller', '$scope', 'ShowAll',
(Controller, $scope, ShowAll) ->

	class SettingsController extends Controller

		constructor: (@$scope, @showAll) ->
			
			@$scope.getShowAll = =>
				return @showAll

			@$scope.setShowAll = (value) =>
				@showAll = value



	return new SettingsController($scope, ShowAll)
]