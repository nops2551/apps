angular.module('News').factory 'ItemModel', ['Model', (Model) ->

	class ItemModel extends Model

	constructor: () ->
		super()
		@add({id: 1, title: 'test', isImportant: true, isRead: false, feed: 1})

	return new ItemModel()
]