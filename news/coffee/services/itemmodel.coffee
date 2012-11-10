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
['Model', '$rootScope', 'FeedType', 'FeedModel', 'FolderModel',
(Model, $rootScope, FeedType, FeedModel, FolderModel) ->

	class ItemModel extends Model

		constructor: ($rootScope, @feedType, @feedModel, @folderModel) ->
			super('items', $rootScope)			
			@feedCache = {}
			@folderCache = {}
			@folderCacheLastModified = 0
			@importantCache = {}


		add: (item) ->
			# cache for feed access
			if not @feedCache[item.feedId]
				@feedCache[item.feedId] = {}
			@feedCache[item.feedId][item.id] = item
			
			if item.isImportant
				@importantCache[item.id] = item

			item = @bindAdditional(item)
			super(item)


		removeById: (itemId) ->
			# clear caches
			item = @getItemById(itemId)
			delete @feedCache[item.feedId][itemId]
			delete @importantCache[itemId]
			super(itemId)


		_objectToArray: (passedObject) ->
			objectArray = []
			for key, value of passedObject
				objectArray.push(value)
			return objectArray


		getItemsByTypeAndId: (type, id) ->
			switch type
				when @feedType.Feed
					items = @feedCache[id] || {}
					return items

				when @feedType.Subscriptions
					return @getItems()

				when @feedType.Folder
					# invalidate the foldercache if the last modified date is
					# not the currently used one
					if @folderCacheLastModified != @feedModel.getLastModified()
						@folderCache = {}
						@folderCacheLastModified = @feedModel.getLastModified()

					# if the folderarray does not yet exist, build it
					# otherwise use the last generated one
					if @folderCache[id] == undefined
						@folderCache[id] = []
						for feed in @feedModel.getItems()
							if feed.folderId == id
								@folderCache[id].push(feed.id)
					
					items = {}
					for feedId in @folderCache[id]
						# merge objects
						$.extend(items, @feedCache[feedId])

					return items
				
				when @feedType.Starred
					items = {}
					for itemId, valid of @importantCache
						items[itemId] = @getItemById(itemId)
					return items


		setImportant: (itemId, isImportant) ->
			if isImportant
				@importantCache[itemId] = true
				@getItemById(itemId).isImportant = true
			else
				delete @importantCache[itemId]
				@getItemById(itemId).isImportant = false


		bindAdditional: (item) ->
			item.getRelativeDate = ->
				return moment.unix(this.date).fromNow();
			
			item.getAuthorLine = ->
				if this.author != null and this.author.trim() != ""
					return "by " + this.author
				else
					return ""
			return item

	return new ItemModel($rootScope, FeedType, FeedModel, FolderModel)
]