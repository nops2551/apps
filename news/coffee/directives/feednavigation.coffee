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

angular.module('News').directive 'feedNavigation', ->

	return (scope, elm, attr) ->

		jumpTo = ($scrollArea, $item) ->
			position = $item.offset().top - $scrollArea.offset().top + $scrollArea.scrollTop()
			$scrollArea.scrollTop(position)

		jumpToPreviousItem = (scrollArea) ->
			$scrollArea = $(scrollArea)
			$items = $scrollArea.find('.feed_item')
			notJumped = true
			for item in $items
				$item = $(item)
				if $item.position().top >= 0
					$previous = $item.prev()
					# if there are no items before the current one
					if $previous.length > 0
						jumpTo($scrollArea, $previous)

					notJumped = false
					break

			# in case we didnt jump
			if $items.length > 0 and notJumped
				jumpTo($scrollArea, $items.last())


		jumpToNextItem = (scrollArea) ->
			$scrollArea = $(scrollArea)
			$items = $scrollArea.find('.feed_item')
			for item in $items
				$item = $(item)
				if $item.position().top > 1
					jumpTo($scrollArea, $item)
					break

		$(elm).click ->
			$(this).focus()

		$(elm).keydown (e) ->
			# j or right
			if e.keyCode == 74 or e.keyCode == 39
				jumpToNextItem(this)

			# k or left
			else if e.keyCode == 75 or e.keyCode == 37
				jumpToPreviousItem(this)

			scope.$apply attr.feedNavigation
