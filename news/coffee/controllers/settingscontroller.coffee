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

angular.module('News').factory '_SettingsController', ['Controller', (Controller) ->

	class SettingsController extends Controller

		constructor: (@$scope, @$rootScope, @showAll, @persistence, @folderModel, 
						@feedModel) ->
			
			@add = false
			@settings = false
			@addingFeed = false
			@addingFolder = false

			@$scope.getFolders = =>
				return @folderModel.getItems()

			@$scope.getShowAll = =>
				return @showAll.showAll

			@$scope.setShowAll = (value) =>
				@showAll.showAll = value
				@persistence.showAll(value)
				@$rootScope.$broadcast('triggerHideRead')

			@$scope.toggleSettings = =>
				@settings = !@settings

			@$scope.toggleAdd = =>
				@add = !@add

			@$scope.addIsShown = =>
				return @add

			@$scope.settingsAreShown = =>
				return @settings

			@$scope.isAddingFeed = =>
				return @addingFeed

			@$scope.isAddingFolder = =>
				return @addingFolder

			@$scope.addFeed = (url, folder) =>
				@$scope.feedEmptyError = false
				@$scope.feedExistsError = false
				@$scope.feedError = false
			
				if url == undefined or url.trim() == ''
					@$scope.feedEmptyError = true
				else 
					url = url.trim()
					for feed in @feedModel.getItems()
						if url == feed.url # FIXME: can we really compare this
							@$scope.feedExistsError = true
				
				if not (@$scope.feedEmptyError or @$scope.feedExistsError)
					if folder == undefined
						folderId = 0
					else
						folderId = folder.id
					@addingFeed = true
					onSuccess = =>
						@$scope.feedUrl = ''
						@addingFeed = false
					onError = =>
						@$scope.feedError = true
						@addingFeed = false
					@persistence.createFeed(url, folderId, onSuccess, onError)


			@$scope.addFolder = (name) =>
				@$scope.folderEmptyError = false
				@$scope.folderExistsError = false
			
				if name == undefined or name.trim() == ''
					@$scope.folderEmptyError = true
				else 
					name = name.trim()
					for folder in @folderModel.getItems()
						if name.toLowerCase() == folder.name.toLowerCase()
							@$scope.folderExistsError = true
				
				if not (@$scope.folderEmptyError or @$scope.folderExistsError)
					@addingFolder = true
					onSuccess = =>
						@$scope.folderName = ''
						@addingFolder = false
					@persistence.createFolder(name, onSuccess)
				
			@$scope.$on 'opmlUpload', (scope, formData) =>
				@importFromLocal(formData)

			@$scope.$on 'hidesettings', =>
				@add = false
				@settings = false

		importFromLocal: (formData) ->
			@persistence.uploadFromLocal(formData)			

	return SettingsController
]