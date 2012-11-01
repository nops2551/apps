angular.module('News').factory 'FeedModel', ['Model', (Model) ->

	class FeedModel extends Model

		constructor: () ->
			super()
			@add({id: 1, name: 'test', unreadCount: 5, folder: 0, icon: 'url(http://feeds.feedburner.com/favicon.ico);'})
			@add({id: 2, name: 'sub', unreadCount: 5, folder: 1, icon: 'url(http://feeds.feedburner.com/favicon.ico);'})


	return new FeedModel()
]