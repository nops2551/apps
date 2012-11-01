<div class="content_wrapper" ng-app="News">
	<div id="leftcontent_news" class="leftcontent_news">
		<div id="feed_wrapper">
			<div id="feeds" ng-controller="FeedController">
				<ul>
					<li ng-class="{
							active: isFeedActive(feedType.Subscriptions, 0),
							all_read: getUnreadCount(feedType.Subscriptions, 0)==0
						}" 
					    class="subscriptions"
					    ng-show="isShown(feedType.Subscriptions, 0)">
						<a class="title" 
						   href="#" 
						   ng-click="loadFeed(feedType.Subscriptions, 0)">
						   <?php p($l->t('New articles'))?>
						</a>
						<span class="unread_items_counter">
							{{ getUnreadCount(feedType.Subscriptions, 0) }}
						</span>
						<span class="buttons">
					    	<button class="svg action feeds_markread" 
					    	        title="<?php p($l->t('Mark all read')) ?>"></button>
					    </span>
					</li>
					<li ng-class="{
							active: isFeedActive(feedType.Starred, 0),
							all_read: getUnreadCount(feedType.Starred, 0)==0
						}" 
					    class="starred">
						<a class="title" 
						   href="#"
						   ng-click="loadFeed(feedType.Starred, 0)"
						   ng-show="isShown(feedType.Starred, 0)">
						   <?php p($l->t('Starred')) ?>
						</a>
						<span class="unread_items_counter">
							{{ getUnreadCount(feedType.Starred, 0) }}
						</span>
					</li>

					<?php print_unescaped($this->inc('part.listfolder')) ?>
					<?php print_unescaped($this->inc('part.listfeed', array('folderId' => '0'))) ?>

				</ul>
			</div>
		</div>

		<div id="feed_settings" ng-controller="SettingsController">
			<ul class="controls">
				<li id="addfeedfolder" title="<?php p($l->t('Add feed or folder')) ?>">
					<button>
						<img class="svg" 
						     src="<?php print_unescaped(link_to('news', 'img/add.svg')) ?>" 
						     alt="<?php p($l->t('Add Feed/Folder')) ?>" /></button>
					<ul class="menu" id="feedfoldermenu">
						<li id="addfeed"><?php p($l->t('Feed')); ?></li>
						<li id="addfolder"><?php p($l->t('Folder')); ?></li>
					</ul>
				</li>
				<li class="view show_all" 
				    ng-show="getShowAll()"
				    ng-click="setShowAll(false)"
				    title="<?php p($l->t('Show everything')); ?>">
					<button></button>
				</li>
				<li class="view show_unread" 
					ng-show="!getShowAll()"
					ng-click="setShowAll(true)"
					title="<?php p($l->t('Show only unread')); ?>">
					<button></button>
				</li>
				<li style="float: right">
					<button id="settingsbtn" 
					        title="<?php p($l->t('Settings')); ?>">
					    <img class="svg" 
					         src="<?php print_unescaped(image_path('core','actions/settings.png')); ?>" 
					         alt="<?php p($l->t('Settings')); ?>"   />
					</button>
				</li>
			</ul>
		</div>
	</div>

	<div id="rightcontent" class="rightcontent">
		<div id="feed_items">
			<?php //echo $this->inc("part.shared");
				print_unescaped($this->inc("part.items"));
			?>
		</div>
		
		<div id="appsettings" class="popup bottomleft hidden"></div>

	</div>
</div>