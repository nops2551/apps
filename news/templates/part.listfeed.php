<li ng-class="{active: isFeedActive(feedType.Feed, feed.id)}" 
    ng-repeat="feed in feeds|feedInFolder:<?php p($_['folderId']); ?>"
    ng-show="feed.show"
    class="feed">
	<a ng-style="{backgroundImage: feed.icon}"
	   href="#"
	   class="title"
	   ng-click="loadFeed(feedType.Feed, feed.id)">
	   {{feed.name}}
	</a>
	<span class="unread_items_counter">
		{{ getUnreadCount(feedType.Feed, feed.id) }}
	</span>
	<span class="buttons">
		<button ng-click="delete(feedType.Feed, feed.id)"
		        class="svg action feeds_delete" 
		        title="<?php p($l->t('Delete feed')); ?>"></button>
		<button class="svg action feeds_markread" 
		        ng-click="markRead(feedType.Feed, feed.id)"
		        title="<?php p($l->t('Mark all read')); ?>"></button>
	</span>
</li>