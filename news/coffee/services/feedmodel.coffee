angular.module('News').factory 'FeedModel', ['Model', (Model) ->

	class FeedModel extends Model

		constructor: () ->
			super()
			@add({id: 1, name: 'test', unreadCount: 0, folder: 0, show: true, icon: 'url(http://feeds.feedburner.com/favicon.ico)'})
			@add({id: 2, name: 'sub', unreadCount: 7, folder: 1, show: true, icon: 'url(http://feeds.feedburner.com/favicon.ico)'})


	return new FeedModel()
]