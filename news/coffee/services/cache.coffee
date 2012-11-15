angular.module('News').factory 'Cache', 
['FeedType', 'FeedModel', 'FolderModel',
(FeedType, FeedModel, FolderModel) ->

	class Cache

		constructor: (@feedType, @feedModel, @folderModel) ->
			@clear()


		clear: ->
			@feedCache = {}
			@folderCache = {}
			@folderCacheLastModified = 0
			@importantCache = {}
			@highestId = 0
			@lowestId = 0
			@highestTimestamp = 0
			@lowestTimestamp = 0
			@highestIds = {}
			@lowestIds = {}
			@highestTimestamps = {}
			@lowestTimestamps = {}


		add: (item) ->
			# cache for feed access
			if not @feedCache[item.feedId]
				@feedCache[item.feedId] = {}
			@feedCache[item.feedId][item.id] = item
			
			# cache for non feeds
			if @highestTimestamp < item.date
				@highestTimestamp = item.date
			if @lowestTimestamp > item.date
				@lowestTimestamp = item.date
			if @highestId < item.id
				@highestId = item.id
			if @lowestId > item.id
				@lowestId = item.id


			# cache for important
			if item.isImportant
				@importantCache[item.id] = item

			# cache lowest and highest ids and timestamps for only fetching new
			# items
			if @highestTimestamps[item.feedId] == undefined or item.id > @highestTimestamps[item.feedId]
				@highestTimestamps[item.feedId] = item.date
			if @lowestTimestamps[item.feedId] == undefined or item.id > @lowestTimestamps[item.feedId]
				@lowestTimestamps[item.feedId] = item.date
			if @highestIds[item.feedId] == undefined or item.id > @highestIds[item.feedId]
				@highestIds[item.feedId] = item.id
			if @lowestIds[item.feedId] == undefined or item.id > @lowestIds[item.feedId]
				@lowestIds[item.feedId] = item.id


		buildFolderCache: (id) ->
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


		remove: (item) ->
			delete @feedCache[item.feedId][item.id]
			delete @importantCache[item.id]


		setImportant: (itemId, isImportant) ->
			if isImportant
				@importantCache[itemId] = true
			else
				delete @importantCache[itemId]

			
		getHighestId: (type, id) ->
			if @isFeed(type)
				return @highestIds[id] || 0
			else
				return @highestId


		getHighestTimestamp: (type, id) ->
			if @isFeed(type)
				return @highestTimestamps[id] || 0
			else
				return @highestTimestamp


		getLowestId: (type, id) ->
			if @isFeed(type)
				return @lowestIds[id] || 0
			else
				return @lowestId


		getLowestTimestamp: (type, id) ->
			if @isFeed(type)
				return @lowestTimestamps[id] || 0
			else
				return @lowestTimestamp


		isFeed: (type) ->
			return type == @feedType.Feed


	return new Cache(FeedType, FeedModel, FolderModel)
]


