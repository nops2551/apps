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

angular.module('News', []).
	config($provide) ->
		# enter your config values in here
		$provide.value('MarkReadTimeout', 500)
		$provide.value('ScrollTimeout', 500)
	.run ['PersistenceNews', (PersistenceNews) ->
		console.log 'hi'
	]


$(document).ready ->
	$('#feeds li').click ->
		$('#feed_items').scrollTop(0)

	$('#feed_items').scrollTop(0)



