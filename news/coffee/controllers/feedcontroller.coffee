angular.module('News').controller 'FeedController', 
['Controller', '$scope', 'FeedModel', 'FeedType', 'FolderModel', 'ActiveFeed', 'PersistenceNews',
'StarredCount', 'ShowAll'
(Controller, $scope, FeedModel, FeedType, FolderModel, ActiveFeed, PersistenceNews
StarredCount, ShowAll) ->

	class FeedController extends Controller

		constructor: (@$scope, @feedModel, @folderModel, @feedType, @activeFeed, 
					  @persistence, @starredCount, @showAll) ->

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

			@$scope.$on 'triggerHideRead', =>
				@triggerHideRead()

			# init functions
			@triggerHideRead()			


		triggerHideRead: () ->
			for feed in @feedModel.getItems()
				if @showAll.showAll == false && @getUnreadCount(@feedType.Feed, feed.id) == 0
					feed.show = false
				else
					feed.show = true

			for folder in @folderModel.getItems()
				if @showAll.showAll == false && @getUnreadCount(@feedType.Folder, folder.id) == 0
					folder.show = false
				else
					folder.show = true


		getUnreadCount: (type, id) ->
			switch type
				when @feedType.Feed 
					return @feedModel.getItemById(id).unreadCount

				when @feedType.Folder
					counter = 0
					for feed in @feedModel.getItems()
						if feed.folder == id
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
								ActiveFeed, PersistenceNews, StarredCount, ShowAll)
]