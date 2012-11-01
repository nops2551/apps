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


			@batchSize = 4
			@loaderQueue = 0
			

			@$scope.items = @itemModel.getItems()

			@$scope.loadNext = =>
				console.info 'scrolled'


		getItemOffset: () ->
			return @$scope.items.length


		incrementLoaderQueue: ->
			console.log @loaderQueue
			@loaderQueue += 1


		loaderQueueIsFull: ->
			if @loaderQueue > @batchSize
				@loaderQueue = 0
				return true
			else
				return false


		pushBatch: ->
			for i in [1..@batchSize]
				console.log 'filling'
				item = {id: i+@getOffset(), title: 'test ' + i, isImportant: true, isRead: false, feed: 1, body: '<p>this is a second test</p>'}
				@$scope.items.push(item)



	return new ItemController($scope, ItemModel, ActiveFeed)
]