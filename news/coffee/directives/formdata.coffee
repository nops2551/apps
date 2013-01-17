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

angular.module('News').directive 'formData', ['$rootScope', ($rootScope) ->

	return (scope, elm, attr) ->
		$(elm).change ->
			formData = new FormData()
			formData.append 'file', elm.file
			$rootScope.$broadcast 'opmlUpload', formData

]