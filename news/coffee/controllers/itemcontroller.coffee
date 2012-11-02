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
['Controller', '$scope', 'ItemModel', 'ActiveFeed', 'PersistenceNews', 'FeedModel',
'StarredCount', 'GarbageRegistry', 'ShowAll',
(Controller, $scope, ItemModel, ActiveFeed, PersistenceNews, FeedModel, 
StarredCount, GarbageRegistry, ShowAll) ->

	class ItemController extends Controller

		constructor: (@$scope, @itemModel, @activeFeed, @persistence, @feedModel,
						@starredCount, @garbageRegistry, @showAll) ->

			@batchSize = 4
			@loaderQueue = 0
			
			@$scope.items = @itemModel.getItems()


			@$scope.scroll = =>
				#console.log 'scrolling'

			@$scope.activeFeed = @activeFeed

			@$scope.$on 'read', (scope, params) =>
				@$scope.markRead(params.id, params.feed)


			@$scope.markRead = (itemId, feedId) =>
				item = @itemModel.getItemById(itemId)
				feed = @feedModel.getItemById(feedId)
				
				if not item.keptUnread && !item.isRead
					item.isRead = true
					feed.unReadCount -= 1

					# this item will be completely deleted if showAll is false
					if not @showAll.showAll
						@garbageRegistry.register(item.id)

					@persistence.markRead(itemId, true)


			@$scope.keepUnread = (itemId, feedId) =>
				item = @itemModel.getItemById(itemId)
				feed = @feedModel.getItemById(feedId)

				
				item.keptUnread = !item.keptUnread

				if item.isRead
					item.isRead = false
					feed.unReadCount += 1

					# if we marked it as to be deleted, unregister it from being
					# deleted
					if not @showAll.showAll
						@garbageRegistry.unregister(item.id)

					@persistence.markRead(itemId, false)


			@$scope.isKeptUnread = (itemId) =>
				return @itemModel.getItemById(itemId).keptUnread


			@$scope.toggleImportant = (itemId) =>
				item = @itemModel.getItemById(itemId)
				
				item.isImportant = !item.isImportant
				if item.isImportant
					@starredCount.count += 1
				else
					@starredCount.count -= 1

				@persistence.setImportant(itemId, item.isImportant)


	return new ItemController($scope, ItemModel, ActiveFeed, PersistenceNews
								FeedModel, StarredCount, GarbageRegistry, 
								ShowAll)
]