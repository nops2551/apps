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

angular.module('News').factory 'FolderModel', 
['Model', '$rootScope', 
(Model, $rootScope) ->

	class FolderModel extends Model

		constructor: (@$rootScope) ->
			super()
			@$rootScope.$on 'update', (scope, data) =>
				if data['folders']
					for folder in data['folders']
						@add(folder)

	return new FolderModel($rootScope)
]