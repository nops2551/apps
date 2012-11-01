<li ng-class="{
	active: isFeedActive(feedType.Folder, folder.id), 
	open: folder.open,
	collapsable: folder.hasChildren	
}" 
    ng-repeat="folder in folders"
    class="folder">
    <button class="collapsable_trigger" 
            title="<?php echo $l->t('Collapse');?>"
            ng-click="toggleFolder(folder.id)"></button>
	<a href="#" 
	   class="title"
	   ng-click="loadFeed(feedType.Folder, folder.id)">
	   {{folder.name}}
	</a>
	<span class="unread_items_counter">
		{{ getUnreadCount(feedType.Folder, folder.id) }}
	</span>
	<span class="buttons">
		<button ng-click="delete(feedType.Folder, folder.id)"
		        class="svg action feeds_delete" 
		        title="<?php echo $l->t('Delete folder'); ?>"></button>
		<button class="svg action feeds_edit" 
				ng-click="rename(feedType.Folder, folder.id)"
		        title="<?php echo $l->t('Rename folder'); ?>"></button>
		<button class="svg action feeds_markread" 
		        ng-click="markRead(feedType.Folder, folder.id)"
		        title="<?php echo $l->t('Mark all read'); ?>"></button>
	</span>
	<ul>
		<?php echo $this->inc('part.listfeed', array('folderId' => 'folder.id')); ?>
	</ul>
</li>