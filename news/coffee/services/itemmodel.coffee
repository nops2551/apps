angular.module('News').factory 'ItemModel', ['Model', (Model) ->

    class ItemModel extends Model

    return new ItemModel()
]