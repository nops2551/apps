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
['Model', '$rootScope', 
(Model, $rootScope) ->

	class ItemModel extends Model

		constructor: (@$rootScope) ->
			super()
			@$rootScope.$on 'update', (scope, data) =>
				if data['items']
					for item in data['items']
						@add(item)


		add: (item) ->
			item = @bindHelperFunctions(item)
			super(item)


		bindHelperFunctions: (item) ->
			item.getRelativeDate = ->
				return moment.unix(this.date).fromNow();
			return item

	return new ItemModel($rootScope)
]