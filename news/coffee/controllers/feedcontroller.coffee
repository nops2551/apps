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

angular.module('News').controller 'FeedController', 
['Controller', '$scope', 'FeedModel', 'FeedType', 'FolderModel', 'ActiveFeed', 'PersistenceNews',
'StarredCount', 'ShowAll', 'ItemModel',
(Controller, $scope, FeedModel, FeedType, FolderModel, ActiveFeed, PersistenceNews
StarredCount, ShowAll, ItemModel) ->

	class FeedController extends Controller

		constructor: (@$scope, @feedModel, @folderModel, @feedType, @activeFeed, 
					  @persistence, @starredCount, @showAll, @itemModel) ->

			@showSubscriptions = true
			@showStarred = true
			@triggerHideRead()

			@$scope.feeds = @feedModel.getItems()
			@$scope.folders = @folderModel.getItems()
			@$scope.feedType = @feedType
			
			@$scope.toggleFolder = (folderId) =>
				folder = @folderModel.getItemById(folderId)
				folder.open = !folder.open
				@persistence.collapseFolder(folder.id, folder.open)

			@$scope.isFeedActive = (type, id) =>
				if type == @activeFeed.type && id == @activeFeed.id
					return true
				else
					return false

			@$scope.loadFeed = (type, id) =>
				@activeFeed.id = id
				@activeFeed.type = type
				@$scope.triggerHideRead()
				# TODO: send load command to server

			@$scope.getUnreadCount = (type, id) =>
				@getUnreadCount(type, id)

			@$scope.triggerHideRead = =>
				@triggerHideRead()

			@$scope.isShown = (type, id) =>
				switch type
					when @feedType.Subscriptions then return @showSubscriptions
					when @feedType.Starred then return @showStarred

			@$scope.$on 'triggerHideRead', =>
				@triggerHideRead()



		triggerHideRead: () ->
			preventParentFolder = 0

			# feeds
			for feed in @feedModel.getItems()
				if @showAll.showAll == false &&	@getUnreadCount(@feedType.Feed, feed.id) == 0

					# we dont hide the selected feed and folder. But we also dont hide
					# the parent folder of the selcted feed
					if @activeFeed.type == @feedType.Feed && @activeFeed.id == feed.id
						feed.show = true
						preventParentFolder = feed.folderId
					else
						feed.show = false
				else
					feed.show = true

			# folders
			for folder in @folderModel.getItems()
				if @showAll.showAll == false && @getUnreadCount(@feedType.Folder, folder.id) == 0
					# prevent hiding when childfeed is active
					if (@activeFeed.type == @feedType.Folder && @activeFeed.id == folder.id) ||	preventParentFolder == folder.id
						folder.show = true
					else
						folder.show = false
				else
					folder.show = true

			# subscriptions
			if @showAll.showAll == false && @getUnreadCount(@feedType.Subscriptions, 0) == 0
				if @activeFeed.type == @feedType.Subscriptions
					@showSubscriptions = true
				else
					@showSubscriptions = false
			else
				@showSubscriptions = true

			# starred
			if @showAll.showAll == false && @getUnreadCount(@feedType.Starred, 0) == 0
				if @activeFeed.type == @feedType.Starred
					@showStarred = true
				else
					@showStarred = false
			else
				@showStarred = true

			@clearReadItems()


		clearReadItems: () ->
			# delete read items for performance reasons when showAll == false
			if @showAll.showAll == false
				removeIds = []
				for item in @itemModel.getItems()
					if item.isRead
						removeIds.push(item.id)
				for id in removeIds
					@itemModel.removeById(id)


		getUnreadCount: (type, id) ->
			switch type
				when @feedType.Feed 
					return @feedModel.getItemById(id).unreadCount

				when @feedType.Folder
					counter = 0
					for feed in @feedModel.getItems()
						if feed.folderId == id
							counter += feed.unreadCount
					return counter

				when @feedType.Starred
					return @starredCount.count

				when @feedType.Subscriptions
					counter = 0
					for feed in @feedModel.getItems()
						counter += feed.unreadCount
					return counter


	return new FeedController($scope, FeedModel, FolderModel, FeedType, 
								ActiveFeed, PersistenceNews, StarredCount, ShowAll,
								ItemModel)
]