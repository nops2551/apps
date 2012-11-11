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

		constructor: (@reactOn, @$rootScope) ->
			@clearCache()

			@$rootScope.$on 'update', (scope, data) =>
				if data[@reactOn]
					for item in data[@reactOn]
						@add(item)


		add: (item) ->
			if not @feedCache[item.feedId]
				@feedCache[item.feedId] = {}
			@feedCache[item.feedId][item.id] = item
			
			# cache for important
			if item.isImportant
				@importantCache[item.id] = item

			# cache lowest and highest ids and timestamps for only fetching new
			# items
			if @highestTimestamp[item.feedId] == undefined or item.id > @highestTimestamp[item.feedId]
				@highestTimestamp[item.feedId] = item.id
			if @lowestTimestamp[item.feedId] == undefined or item.id > @lowestTimestamp[item.feedId]
				@lowestTimestamp[item.feedId] = item.id
			if @highestId[item.feedId] == undefined or item.id > @highestId[item.feedId]
				@highestId[item.feedId] = item.id
			if @lowestId[item.feedId] == undefined or item.id > @lowestId[item.feedId]
				@lowestId[item.feedId] = item.id


		clearCache: () ->
			@items = []
			@itemIds = {}
			@markAccessed()


		markAccessed: () ->
			@lastAccessed = new Date().getTime()


		getLastModified: () ->
			return @lastAccessed


		add: (item) ->
			if @itemIds[item.id] == undefined
				@items.push(item)
				@itemIds[item.id] = item
				@markAccessed()
			else
				@update(item)


		update: (item) ->
			updatedItem = @itemIds[item.id]
			for key, value of item
				if key != 'id'
					updatedItem[key] = value
			@markAccessed()


		removeById: (id) ->
			removeItemIndex = null
			counter = 0
			for item in @items
				if item.id == id
					removeItemIndex = counter
					break
				counter += 1

			if removeItemIndex != null
				@items.splice(removeItemIndex, 1)
				delete @itemIds[id]
			@markAccessed()


		getItemById: (id) ->
			return @itemIds[id]


		getItems: () ->
			return @items