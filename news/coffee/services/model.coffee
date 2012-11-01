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

angular.module('News').factory 'Model', ->

	class Model

		constructor: () ->
			@items = []
			@itemIds = {}


		add: (item) ->
			# check if we need to update or create the item
			if item.id of @itemIds
				@update(item)
			else
				@items.push(item)
				@itemIds[item.id] = item


		update: (item) ->
			updatedItem = @items[item.id]
			for key, value of item
				if key != 'id'
					updatedItem[key] = value


		removeById: (id) ->
			removeItemIndex = null
			for item, counter in @items
				if item.id == id
					removeItemIndex = counter
			if removeItemIndex != null
				@items.splice(removeItemId, 1)
				delete @itemIds[id]


		getItemById: (id) ->
			return @itemIds[id]


		getItems: () ->
			return @items