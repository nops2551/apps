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

angular.module('News').factory 'ActiveFeed', ['_ActiveFeed', (_ActiveFeed) ->
	return new _ActiveFeed()
]

angular.module('News').factory 'ShowAll', ['_ShowAll', (_ShowAll) ->
	return new _ShowAll()
]

angular.module('News').factory 'Publisher', ['_Publisher', (_Publisher) ->
	return new _Publisher()
]

angular.module('News').factory 'Loading', ['_Loading', (_Loading) ->
	return new _Loading()
]

angular.module('News').factory 'StarredCount', ['_StarredCount', (_StarredCount) ->
	return new _StarredCount()
]