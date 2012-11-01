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

		type = typeAndId.type
		id = typeAndId.id
		switch type
			when FeedType.Subscriptions then return items
			when FeedType.Starred
				for item in items
					if item.isImportant
						result.push(item)

			when FeedType.Folder
				for item in items
					feedId = 0
					for feed in FeedModel.getItems()
						if feed.folderId == id
							feedId = feed.id
					if item.feedId == feedId
						result.push(item)

			when FeedType.Feed
				for item in items
					if item.feedId == id
						result.push(item)

		return result
	]