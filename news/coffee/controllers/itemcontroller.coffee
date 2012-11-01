angular.module('News').controller 'ItemController', 
['Controller', '$scope', 'ItemModel', 'ActiveFeed',
(Controller, $scope, ItemModel, ActiveFeed) ->

	class ItemController extends Controller

		constructor: (@$scope, @itemModel, @activeFeed) ->
			
			@$scope.items = @itemModel.getItems()


	return new ItemController($scope, ItemModel, ActiveFeed)
]