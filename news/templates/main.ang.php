<div id="leftcontent_news" class="leftcontent_news" ngapp="News">
	<div id="feed_wrapper">
		<div id="feeds">
			<ul data-id="0">
				<li class="subscriptions <?php if($lastViewedFeedType == OCA\News\FeedType::SUBSCRIPTIONS) { echo "active"; }; ?>">
					<a class="title" href="#" ><?php echo $l->t('New articles'); ?></a>
					<span class="unread_items_counter"><?php echo $starredCount ?></span>
					<span class="buttons">
				    	<button class="svg action feeds_markread" title="<?php echo $l->t('Mark all read'); ?>"></button>
				    </span>
				</li>
				<li class="starred <?php if($lastViewedFeedType == OCA\News\FeedType::STARRED) { echo "active"; }; ?>">
					<a class="title" href="#" ><?php echo $l->t('Starred'); ?></a>
					<span class="unread_items_counter"><?php echo $starredCount ?></span>
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