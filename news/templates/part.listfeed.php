<li ng-class="{active: isFeedActive(feedType.Feed, feed.id)}" 
    ng-repeat="feed in feeds|feedInFolder:<?php echo $_['folderId']; ?>"
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
		        title="<?php echo $l->t('Delete feed'); ?>"></button>
		<button class="svg action feeds_markread" 
		        ng-click="markRead(feedType.Feed, feed.id)"
		        title="<?php echo $l->t('Mark all read'); ?>"></button>
	</span>
</li>