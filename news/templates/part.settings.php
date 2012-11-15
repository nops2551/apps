<div id="feed_settings" 
		ng-controller="SettingsController" 
		ng-class="{expanded: isExpanded()}">
	<ul class="controls">
		<li title="<?php p($l->t('Add feed or folder')) ?>">
			<button ng-click="toggleAdd()">
				<img class="svg" 
				     src="<?php print_unescaped(link_to('news', 'img/add.svg')) ?>" 
				     alt="<?php p($l->t('Add Feed/Folder')) ?>" /></button>
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
			        title="<?php p($l->t('Settings')); ?>"
			        ng-click="toggleSettings()">
			    <img class="svg" 
			         src="<?php print_unescaped(image_path('core','actions/settings.png')); ?>" 
			         alt="<?php p($l->t('Settings')); ?>"   />
			</button>
		</li>
	</ul>

	<div class="open_add" ng-show="addIsShown()">
		<fieldset class="personalblock">
			<legend><strong><?php p($l->t('Add Folder')); ?></strong></legend>
			<form name="addFolderForm">
				<input type="text" 
						ng-model="folderName" 
						name="folderName"
						placeholder="<?php p($l->t('Name')); ?>">
				<button title="<?php p($l->t('Add')); ?>" 
						ng-click="addFolder(folderName)"><?php p($l->t('Add')); ?></button>
			</form>
		</fieldset>
		<fieldset class="personalblock">
			<legend><strong><?php p($l->t('Add Subscription')); ?></strong></legend>
			<form>
				<input type="text" 
					ng-model="feedUrl" 
					on-enter="addFeed(feedUrl)" 
					placeholder="<?php p($l->t('Adress')); ?>" 
					required="required">
				<button title="<?php p($l->t('Add')); ?>" 
						ng-click="addFeed(feedUrl)"><?php p($l->t('Add')); ?></button>
			<form>	
		</fieldset>
	</div>

	<div class="open_settings" ng-show="settingsAreShown()">
		<fieldset class="personalblock">
			<legend><strong><?php p($l->t('Subscribelet')); ?></strong></legend>
			<p><?php print_unescaped($this->inc('part.subscribelet'));?>
			</p>
		</fieldset>
		<fieldset class="personalblock">
			<legend><strong><?php p($l->t('Import OPML')); ?></strong></legend>
			<button title="<?php p($l->t('From disk')); ?>"><?php p($l->t('From disk')); ?></button>
			<button title="<?php p($l->t('From cloud')); ?>"><?php p($l->t('From cloud')); ?></button>
		</fieldset>
		<fieldset class="personalblock">
			<legend><strong><?php p($l->t('Export')); ?></strong></legend>
			<button title="<?php p($l->t('Download OPML')); ?>"><?php p($l->t('Download OPML')); ?></button>
		</fieldset>

	</div>
</div>
