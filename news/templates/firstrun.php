<div id="firstrun">
	<h1><?php p($l->t("You don't have any feed in your reader.")) ?></h1>
	<div id="selections">
		<fieldset id="addfeed_dialog_firstrun">
			<legend style="margin-left:10px;">
				<img src="<?php print_unescaped(image_path('news','rss.svg')); ?>"> <?php p($l->t('Add feed')) ?>
			</legend>
			<input type="text" id="feed_add_url" placeholder="<?php p($l->t('Address')); ?>" />
			<input type="submit" value="<?php p($l->t('Subscribe')); ?>" onclick="News.Feed.submit(this)" id="feed_add_submit" />
		</fieldset>
		<br />
		<fieldset id="importopml_dialog_firstrun">
		<legend style="margin-left:10px">
			<img src="<?php print_unescaped(image_path('news','opml-icon.svg')); ?>"> <?php p($l->t('Import OPML')) ?>
		</legend>
			<button class="svg" id="browsebtn_firstrun" title="<?php p($l->t('Upload file from desktop')); ?>" onclick="News.DropDownMenu.fade('ul#feedfoldermenu')">
				<img class="svg" src="<?php print_unescaped(image_path('core','actions/upload.svg')); ?>" alt="<?php p($l->t('Upload')); ?>"   />
			</button>
			<button class="svg" id="cloudbtn_firstrun" title="<?php p($l->t('Select file from ownCloud')); ?>">
				<img class="svg" src="<?php print_unescaped(image_path('core','actions/upload.svg')); ?>" alt="<?php p($l->t('Select')); ?>"   />
			</button>
			<span id="opml_file">
			<?php print_unescaped($l->t('Select file from <a href="#" class="settings" id="browselink">local filesystem</a> or <a href="#" class="settings" id="cloudlink">cloud</a>')); ?>
			</span>
			<input type="file" id="file_upload_start" name="files[]" />
			<input style="float: right" id="importbtn_firstrun" type="submit" value="<?php p($l->t('Import'));?>" />
		</fieldset>
	</div>
	<div>
	
	<?php
	require_once OC_App::getAppPath('news') .'/templates/subscribelet.php';
	?>
	
	<h1><?php p($l->t('Or...')) ?></h1>

	<?php createSubscribelet(); ?>
	</div>
</div>
