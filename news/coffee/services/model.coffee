angular.module('News').factory 'Model', ->

	class Model

		constructor: () ->
			@_items = []
			@_itemIds = {}


		add: (item) ->
			@_items.push(item)
			@_itemIds[item.id] = item


		update: (item) ->
			@_items = item


		removeById: (id) ->
			removeItemIndex = null
			for item, counter in @items
				if item.id == id
					removeItemIndex = counter
			if removeItemIndex != null
				@items.splice(removeItemId, 1)
				delete @_itemIds[id]


		getItemById: (id) ->
			return @_itemIds[id]


		getItems: () ->
			return @_items