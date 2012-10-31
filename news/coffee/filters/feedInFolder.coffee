angular.module('News').filter 'feedInFolder', ->
    return (feeds, folderId) ->
        result = []
        for feed in feeds
            if feed.folder == folderId
                result.push(feed)
        return result