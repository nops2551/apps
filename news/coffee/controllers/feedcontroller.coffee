angular.module('News').controller 'FeedController', 
['Controller', '$scope', 'FeedModel', 'FeedType', 'FolderModel', 'ActiveFeed', 'PersistenceNews',
(Controller, $scope, FeedModel, FeedType, FolderModel, ActiveFeed, PersistenceNews) ->

	class FeedController extends Controller

		constructor: (@$scope, @feedModel, @folderModel, feedType, @activeFeed, @persistence) ->

			@$scope.feeds = @feedModel.getItems()
			@$scope.folders = @folderModel.getItems()
			@$scope.feedType = feedType

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
				# TODO: send load command to server


	return new FeedController($scope, FeedModel, FolderModel, FeedType, ActiveFeed, PersistenceNews)
]