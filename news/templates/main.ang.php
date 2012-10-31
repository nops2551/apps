<div id="leftcontent_news" class="leftcontent_news" ng-app="News">
	<div id="feed_wrapper">
		<div id="feeds" ng-controller="FeedController">
			<ul>
				<li ng-class="{true: active}[isFeedActive(feedType.Subscriptions, 0)]" 
				    class="subscriptions">
					<a class="title" 
					    href="#" ><?php echo $l->t('New articles'); ?></a>
					<span class="unread_items_counter">
						{{ getUnreadCount(feedTypes.Subscriptions, 0) }}
					</span>
					<span class="buttons">
				    	<button class="svg action feeds_markread" 
				    	        title="<?php echo $l->t('Mark all read'); ?>"></button>
				    </span>
				</li>
				<li ng-class="{true: active}[isFeedActive(feedType.Starred, 0)]" 
				    class="starred">
					<a class="title" 
					   href="#" ><?php echo $l->t('Starred'); ?></a>
					<span class="unread_items_counter">
						{{ getUnreadCount(feedTypes.Starred, 0) }}
					</span>
				</li>

				<!-- Folders -->
				<li ng-class="{true: active}[isFeedActive(feedType.Folder, folder.id)]" 
				    ng-repeat="folder in folders"
				    class="folder">
    				<a style="background-image: url(' . $favicon . ');" 
    				   href="#" class="title">{{folder.name}}</a>
					<span class="unread_items_counter">
						{{ getUnreadCount(feedTypes.Folder, folder.id) }}
					</span>
					<span class="buttons">
						<button class="svg action feeds_delete" title="' . $l->t('Delete feed') . '"></button>
						<button class="svg action feeds_markread" title="' . $l->t('Mark all read') . '"></button>
					</span>
					<ul class="collapsable">
						<li ng-class="{true: active}[isFeedActive(feed.Feed, feed.id)]" 
						    ng-repeat="feed in feeds|feedInFolder:folder.id"
						    class="feed">
		    				<a style="background-image: url(' . $favicon . ');" 
		    				   href="#" class="title">{{feed.name}}</a>
							<span class="unread_items_counter">
								{{ getUnreadCount(feedTypes.Feed, feed.id) }}
							</span>
							<span class="buttons">
								<button class="svg action feeds_delete" title="' . $l->t('Delete feed') . '"></button>
								<button class="svg action feeds_markread" title="' . $l->t('Mark all read') . '"></button>
							</span>
						</li>
					</ul>
				</li>

				<!-- Feeds -->
				<li ng-class="{true: active}[isFeedActive(feed.Feed, feed.id)]" 
				    ng-repeat="feed in feeds|feedInFolder:0"
				    class="feed">
    				<a style="background-image: url(' . $favicon . ');" 
    				   href="#" class="title">{{feed.name}}</a>
					<span class="unread_items_counter">
						{{ getUnreadCount(feedTypes.Feed, feed.id) }}
					</span>
					<span class="buttons">
						<button class="svg action feeds_delete" title="' . $l->t('Delete feed') . '"></button>
						<button class="svg action feeds_markread" title="' . $l->t('Mark all read') . '"></button>
					</span>
				</li>
			</ul>
		</div>
	</div>
	<div id="feed_settings">
		<ul class="controls">
			<li id="addfeedfolder" title="<?php echo $l->t('Add feed or folder'); ?>">
				<button><img class="svg" src="<?php echo OCP\Util::linkTo('news', 'img/add.svg'); ?>" alt="<?php echo $l->t('Add Feed/Folder'); ?>" /></button>
				<ul class="menu" id="feedfoldermenu">
					<li id="addfeed"><?php echo $l->t('Feed'); ?></li>
					<li id="addfolder"><?php echo $l->t('Folder'); ?></li>
				</ul>
			</li>
			<li id="view" title="<?php echo $viewButtonTitle; ?>" class="<?php echo $viewButtonClass; ?>">
				<button></button>
			</li>
			<li style="float: right">
				<button id="settingsbtn" title="<?php echo $l->t('Settings'); ?>"><img class="svg" src="<?php echo OCP\Util::imagePath('core','actions/settings.png'); ?>" alt="<?php echo $l->t('Settings'); ?>"   /></button>
			</li>
		</ul>
	</div>
</div>

<div id="rightcontent" class="rightcontent">
	<?php/*
			echo '<div id="feed_items">';
				//echo $this->inc("part.shared");
				echo $this->inc("part.items");
			echo '</div>';
		*/
	?>

	<div id="appsettings" class="popup bottomleft hidden"></div>

</div>