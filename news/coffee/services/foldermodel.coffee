###
# ownCloud - News app
#
# @author Bernhard Posselt
# Copyright (c) 2012 - Bernhard Posselt <nukeawhale@gmail.com>
#
# This file is licensed under the Affero General Public License version 3 or later.
# See the COPYING-README file
#
###

angular.module('News').factory 'FolderModel', ['Model', (Model) ->

	class FolderModel extends Model

		constructor: () ->
			super()
			@add({id: 1, name: 'folder', open: true, hasChildren: true})
			@add({id: 2, name: 'testfolder', open: true, hasChildren: false})


	return new FolderModel()
]