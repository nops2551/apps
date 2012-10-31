angular.module('News').factory 'FeedType', ->
	feedType = 
		Feed: 0
		Folder: 1
		Starred: 2
		Subscriptions: 3
		Shared: 4