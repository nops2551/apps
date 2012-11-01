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

angular.module('News').filter 'itemInFeed', ['FeedType', 'FeedModel', (FeedType, FeedModel) ->
	return (items, typeAndId) ->
		result = []

		if typeAndId.type == FeedType.Subscriptions
			return items

		if typeAndId.type == FeedType.Starred
			for item in items
				if item.isImportant
					result.push(item)

		if typeAndId.type == FeedType.Shared
			return result

		if typeAndId.type == FeedType.Folder
			for item in items
				feedId = 0
				for feed in FeedModel.getItems()
					if feed.folder = typeAndId.id
						feedId = feed.id
				if item.feed == feedId
					result.push(item)

		if typeAndId.type == FeedType.Feed
			for item in items
				if item.feed == typeAndId.id
					result.push(item)

		return result
	]