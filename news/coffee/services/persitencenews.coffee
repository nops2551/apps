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

angular.module('News').factory 'PersistenceNews', 
['Persistence', '$http', '$rootScope', 'Loading',
(Persistence, $http, $rootScope, Loading) ->

	class PersistenceNews extends Persistence

		constructor: ($http, @$rootScope, @loading) ->
			super('news', $http)


		loadInitial: () ->
			@loading.loading += 1
			OC.Router.registerLoadedCallback =>

				@post 'init', {}, (json) =>
					@loading.loading -= 1
					@$rootScope.$broadcast('update', json.data)
					@$rootScope.$broadcast('triggerHideRead')
					@setInitialized(true)
				, true


		loadFeed: (type, id, latestFeedId, latestTimestamp, limit=20) ->
			data = 
				type: type
				id: id
				latestFeedId: latestFeedId
				latestTimestamp: latestTimestamp
				limit: limit

			@loading.loading += 1
			@post 'loadfeed', data, (json) =>
				@loading.loading -= 1
				@$rootScope.$broadcast('update', json.data)


		createFeed: (feedUrl) ->
			data = 
				feedUrl: feedUrl
				folderId: folderId
			@post 'createFeed', data


		deleteFeed: (feedId) ->
			data = 
				feedId: feedId
			@post 'deletefeeed', data


		moveFeedToFolder: (feedId, folderId) ->
			data =
				feedId: feedId
				folderId: folderId
			@post 'movefeedtofolder', data


		createFolder: (folderName) ->
			data = 
				folderName: folderName
			@post 'createfolder', data


		deleteFolder: (folderId) ->
			data = 
				folderId: folderId
			@post 'deletefolder', data



		showAll: (isShowAll) ->
			data = 
				showAll: isShowAll
			@post 'setshowall', data


		markRead: (itemId, isRead) ->
			if isRead
				status = 'read'
			else
				status = 'unread'

			data =
				itemId: itemId
				status: status

			@post 'setitemstatus', data


		setImportant: (itemId, isImportant) ->
			if isImportant
				status = 'important'
			else
				status = 'unimportant'

			data =
				itemId: itemId
				status: status

			@post 'setitemstatus', data


		collapseFolder: (folderId, value) ->
			data =
				folderId: folderId
				opened: value
			@post 'collapsefolder', data


		updateFeed: (feedId) ->
			data =
				feedId: feedId

			@post 'updatefeed', data, (json) =>	
				@$rootScope.$broadcast('update', json.data)			


	return new PersistenceNews($http, $rootScope, Loading)
]