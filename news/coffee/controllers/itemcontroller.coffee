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
['Controller', '$scope', 'ItemModel', 'ActiveFeed', 'PersistenceNews', 'FeedModel'
(Controller, $scope, ItemModel, ActiveFeed, PersistenceNews, FeedModel) ->

	class ItemController extends Controller

		constructor: (@$scope, @itemModel, @activeFeed, @persistence, @feedModel) ->

			@batchSize = 4
			@loaderQueue = 0
			
			@$scope.items = @itemModel.getItems()


			@$scope.scroll = =>
				#console.log 'scrolling'


			@$scope.$on 'read', (scope, params) =>
				@$scope.markRead(params.id, params.feed)


			@$scope.markRead = (itemId, feedId) =>
				item = @itemModel.getItemById(itemId)
				feed = @feedModel.getItemById(feedId)
				
				if not item.keptUnread
					item.isRead = true
					feed.unReadCount -= 1

					@persistence.markRead(itemId, true)


			@$scope.keepUnread = (itemId, feedId) =>
				item = @itemModel.getItemById(itemId)
				feed = @feedModel.getItemById(feedId)

				
				item.keptUnread = !item.keptUnread

				if item.isRead
					item.isRead = false
					feed.unReadCount += 1

					@persistence.markRead(itemId, false)


			@$scope.isKeptUnread = (itemId) =>
				return @itemModel.getItemById(itemId).keptUnread




	return new ItemController($scope, ItemModel, ActiveFeed, PersistenceNews
								FeedModel)
]