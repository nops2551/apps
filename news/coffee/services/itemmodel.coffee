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

angular.module('News').factory 'ItemModel', 
['Model', '$rootScope', 'Cache', 'FeedType',
(Model, $rootScope, Cache, FeedType) ->

	class ItemModel extends Model

		constructor: ($rootScope, @cache, @feedType) ->
			super('items', $rootScope)			


		clearCache: () ->
			@cache.clear()
			super()


		add: (item) ->
			item = @bindAdditional(item)
			super(item)
			@cache.add(@getItemById(item.id))			


		bindAdditional: (item) ->
			item.getRelativeDate = ->
				return moment.unix(this.date).fromNow();
			
			item.getAuthorLine = ->
				if this.author != null and this.author.trim() != ""
					return "by " + this.author
				else
					return ""
			return item


		removeById: (itemId) ->
			@cache.remove(@getItemById(itemId))
			super(itemId)

			
		getHighestId: (type, id) ->
			@cache.getHighestId(type, id)


		getHighestTimestamp: (type, id) ->
			@cache.getHighestTimestamp(type, id)			


		getLowestId: (type, id) ->
			@cache.getLowestId(type, id)
			

		getLowestTimestamp: (type, id) ->
			@cache.getLowestTimestamp(type, id)


		getFeedsOfFolderId: (id) ->
			@cache.getFeedsOfFolderId(id)


		getItemsByTypeAndId: (type, id) ->
			switch type
				when @feedType.Feed
					items = @cache.feedCache[id] || {}
					return items

				when @feedType.Subscriptions
					return @getItems()

				when @feedType.Folder
					@cache.buildFolderCache(id)
					
					items = {}
					for feedId in @cache.folderCache[id]
						# merge objects
						$.extend(items, @cache.feedCache[feedId])

					return items
				
				when @feedType.Starred
					items = {}
					for itemId, valid of @cache.importantCache
						items[itemId] = @getItemById(itemId)
					return items


		setImportant: (itemId, isImportant) ->
			@cache.setImportant(itemId, isImportant)
			@getItemById(itemId).isImportant = isImportant



	return new ItemModel($rootScope, Cache, FeedType)
]