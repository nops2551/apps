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

app = angular.module('News', []).config ($provide) ->
	# enter your config values in here
	$provide.value('MarkReadTimeout', 500)
	$provide.value('ScrollTimeout', 500)

app.run ['PersistenceNews', (PersistenceNews) ->
	PersistenceNews.loadInitial()
]

$(document).ready ->
	# this is used to forces browser to reload content after refreshing
	# and thus clearing the scroll cache
	$(this).keyup (e) ->
		if (e.which == 116) || (e.which == 82 && e.ctrlKey)
			document.location.reload(true);
			return false

