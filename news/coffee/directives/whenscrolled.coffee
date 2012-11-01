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

scrolling = true
markingRead = true

angular.module('News').directive 'whenScrolled',
['$rootScope', 'MarkReadTimeout', 'ScrollTimeout'
($rootScope, MarkReadTimeout, ScrollTimeout) ->

	return (scope, elm, attr) ->

		elm.bind 'scroll', ->
			# prevent from doing to many scroll actions
			# the first timeout prevents accidental and too early marking as read
			if scrolling
				scrolling = false
				setTimeout ->
					scrolling = true
				, ScrollTimeout

				if markingRead
					markingRead = false
					setTimeout ->
						markingRead = true
						# only broadcast elements that are not already read
						# and that are beyond the top border
						$(elm).find('.feed_item:not(.read)').each ->
							
							id = parseInt($(this).data('id'), 10)
							feed = parseInt($(this).data('feed'), 10)
							
							offset = $(this).position().top
							if offset <= 0
								$rootScope.$broadcast('read', {id: id, feed: feed})

					, MarkReadTimeout

				scope.$apply attr.whenScrolled;

]

