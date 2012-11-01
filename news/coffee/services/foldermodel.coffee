angular.module('News').factory 'FolderModel', ['Model', (Model) ->

	class FolderModel extends Model

		constructor: () ->
			super()
			@add({id: 1, name: 'folder', unreadCount: 5, open: true, hasChildren: true})
			@add({id: 2, name: 'testfolder', unreadCount: 5, open: true, hasChildren: false})


	return new FolderModel()
]