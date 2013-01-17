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
			console.log elm
			console.log elm[0]
			console.log elm[0].files
			formData = new FormData()
			formData.append 'file', elm[0].files[0]
			$rootScope.$broadcast 'opmlUpload', formData

]