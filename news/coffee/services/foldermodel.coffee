angular.module('News').factory 'FolderModel', ['Model', (Model) ->

	class FolderModel extends Model

	constructor: () ->
		super()
		@add({id: 1, type: 1, name: 'test', unreadCount: 5, open: true, hasChildren: true})


	return new FolderModel()
]