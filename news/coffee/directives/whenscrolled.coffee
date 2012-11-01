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

angular.module('News').directive 'whenScrolled', ->
	return (scope, elm, attr) ->

		scrollTimeout = 500

		elm.bind 'scroll', ->
			if scrolling
				scrolling = false
				setTimeout ->
					scrolling = true
				, scrollTimeout
				scope.$apply attr.whenScrolled;



