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
			@post 'init', {}, (json) =>
				@loading.loading = false
				@$rootScope.$broadcast('update', json.data)


		showAll: (isShowAll) ->
			data = 
				showAll: isShowAll

			@post 'usersettings', data


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


	return new PersistenceNews($http, $rootScope, Loading)
]