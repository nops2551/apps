angular.module('News').controller 'FeedController', 
['Controller', '$scope', 'FeedModel', 'FeedType', 'FolderModel', 
(Controller, $scope, FeedModel, FeedType, FolderModel) ->

    class FeedController extends Controller

        constructor: (@$scope, @feedModel, @folderModel, feedType) ->
            @activeFeed = 
                id: 3
                type: 0

            @$scope.feeds = @feedModel.getItems()
            @$scope.folders = @folderModel.getItems()
            @$scope.feedType = feedType
            @$scope.isFeedActive = (type, id) =>
                if type == @activeFeed.type && id == @activeFeed.id
                    console.log "type " + type  + "is active"
                    return true
                else
                    return false


    return new FeedController($scope, FeedModel, FolderModel, FeedType)
]