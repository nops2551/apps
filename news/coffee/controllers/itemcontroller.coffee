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

angular.module('News').controller 'ItemController', 
['Controller', '$scope', 'ItemModel', 'ActiveFeed',
(Controller, $scope, ItemModel, ActiveFeed) ->

	class ItemController extends Controller

		constructor: (@$scope, @itemModel, @activeFeed) ->
			
			@$scope.items = @itemModel.getItems()


	return new ItemController($scope, ItemModel, ActiveFeed)
]