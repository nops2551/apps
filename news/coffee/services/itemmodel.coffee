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

angular.module('News').factory 'ItemModel', ['Model', (Model) ->

	class ItemModel extends Model

		constructor: () ->
			super()
			@add({id: 1, title: 'test1', isImportant: true, isRead: true, feedId: 1, keptUnread: false, isShown: false, body: '<p>this is a test</p>'})
			@add({id: 2, title: 'test2', isImportant: true, isRead: false, feedId: 1, keptUnread: false, isShown: true, body: '<p>this is a second test</p>'})
			@add({id: 3, title: 'test3', isImportant: true, isRead: false, feedId: 1, keptUnread: false, isShown: true, body: '<p>this is a second test</p>'})
			@add({id: 4, title: 'test4', isImportant: true, isRead: false, feedId: 1, keptUnread: false, isShown: true, body: '<p>this is a second test</p>'})
			@add({id: 5, title: 'test5', isImportant: true, isRead: false, feedId: 1, keptUnread: false, isShown: false, body: '<p>this is a second test</p>'})


	return new ItemModel()
]