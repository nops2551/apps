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

			for i in [1..100] by 1
				item = 
					id: i 
					title: 'test1'
					isImportant: false, 
					date:12*i, 
					isRead: false, 
					feedId: (i%5)+1, 
					keptUnread: false, 
					body: '<p>this is a test' + i + '</p>'
				@add(item)
			

		add: (item) ->
			item = @bindHelperFunctions(item)
			super(item)


		bindHelperFunctions: (item) ->
			item.getRelativeDate = ->
				return moment.unix(this.date).fromNow();
			return item

	return new ItemModel()
]