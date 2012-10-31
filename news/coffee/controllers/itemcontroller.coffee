angular.module('News').controller 'ItemController', 
['Controller', '$scope', (Controller, $scope) ->

    class ItemController extends Controller

        constructor: (@$scope) ->


    return new ItemController($scope)
]