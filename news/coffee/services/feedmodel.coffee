angular.module('News').factory 'FeedModel', ['Model', (Model) ->

    class FeedModel extends Model

        constructor: () ->
        	super()
        	@add({id: 1, name: 'test', unreadCount: 5, folder: 0})
        	@add({id: 2, name: 'sub', unreadCount: 5, folder: 1})


    return new FeedModel()
]