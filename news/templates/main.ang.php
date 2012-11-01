<div class="content_wrapper" ng-app="News">
	<div id="leftcontent_news" class="leftcontent_news">
		<div id="feed_wrapper">
			<div id="feeds" ng-controller="FeedController">
				<ul>
					<li ng-class="{active: isFeedActive(feedType.Subscriptions, 0)}" 
					    class="subscriptions">
						<a class="title" 
						   href="#" 
						   ng-click="loadFeed(feedType.Subscriptions, 0)">
						   <?php echo $l->t('New articles'); ?>
						</a>
						<span class="unread_items_counter">
							{{ getUnreadCount(feedType.Subscriptions, 0) }}
						</span>
						<span class="buttons">
					    	<button class="svg action feeds_markread" 
					    	        title="<?php echo $l->t('Mark all read'); ?>"></button>
					    </span>
					</li>
					<li ng-class="{active: isFeedActive(feedType.Starred, 0)}" 
					    class="starred">
						<a class="title" 
						   href="#"
						   ng-click="loadFeed(feedType.Starred, 0)">
						   <?php echo $l->t('Starred'); ?>
						</a>
						<span class="unread_items_counter">
							{{ getUnreadCount(feedType.Starred, 0) }}
						</span>
					</li>

					<?php echo $this->inc('part.listfolder'); ?>
					<?php echo $this->inc('part.listfeed', array('folderId' => '0')); ?>

				</ul>
			</div>
		</div>

		<div id="feed_settings" ng-controller="SettingsController">
			<ul class="controls">
				<li id="addfeedfolder" title="<?php echo $l->t('Add feed or folder'); ?>">
					<button><img class="svg" src="<?php echo OCP\Util::linkTo('news', 'img/add.svg'); ?>" alt="<?php echo $l->t('Add Feed/Folder'); ?>" /></button>
					<ul class="menu" id="feedfoldermenu">
						<li id="addfeed"><?php echo $l->t('Feed'); ?></li>
						<li id="addfolder"><?php echo $l->t('Folder'); ?></li>
					</ul>
				</li>
				<li class="view show_all" 
				    ng-show="getShowAll()"
				    ng-click="setShowAll(false)"
				    title="<?php echo $l->t('Show everything'); ?>">
					<button></button>
				</li>
				<li class="view show_unread" 
					ng-show="!getShowAll()"
					ng-click="setShowAll(true)"
					title="<?php echo $l->t('Show only unread'); ?>">
					<button></button>
				</li>
				<li style="float: right">
					<button id="settingsbtn" title="<?php echo $l->t('Settings'); ?>"><img class="svg" src="<?php echo OCP\Util::imagePath('core','actions/settings.png'); ?>" alt="<?php echo $l->t('Settings'); ?>"   /></button>
				</li>
			</ul>
		</div>
	</div>

	<div id="rightcontent" class="rightcontent">
		<div id="feed_items">
			<?php //echo $this->inc("part.shared");
				echo $this->inc("part.items");
			?>
		</div>
		
		<div id="appsettings" class="popup bottomleft hidden"></div>

	</div>
</div>