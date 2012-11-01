<dl>
	<dt><?php p($l->t('Import feeds')); ?></dt>
	<dd><button class="svg" id="browsebtn" title="<?php p($l->t('Upload file from desktop')); ?>" 
		        onclick="News.DropDownMenu.fade('ul#feedfoldermenu')">
		        <img class="svg" 
		             src="<?php  print_unescaped(image_path('core','actions/upload.svg')); ?>" 
		             alt="<?php p($l->t('Upload')); ?>"   />
		</button>
	    <button class="svg" id="cloudbtn" 
	            title="<?php p($l->t('Select file from ownCloud')); ?>">
	            <img class="svg" 
	                 src="<?php  print_unescaped(image_path('core','actions/upload.svg')); ?>" 
	                 alt="<?php p($l->t('Select')); ?>"   />
	    </button>
	    <span id="opml_file">
	    	<?php print_unescaped($l->t('Select file from <a href="#" class="settings" id="browselink">local filesystem</a> or <a href="#" class="settings" id="cloudlink">cloud</a>')); ?>
	    </span>
	    <input type="file" id="file_upload_start" name="files[]" />
	    <input style="float: right" id="importbtn" type="submit" value="<?php p($l->t('Import'));?>" />
	</dd>
	<dt><?php p($l->t('Export feeds')); ?></dt>
	<dd>
	    <button id="exportbtn" title="<?php p($l->t('Download OPML')); ?>">Download OPML</button>
	</dd>
	<dt><?php p($l->t('Subscribelet')); ?></dt>
	<dd>
	    <?php
		require_once OC_App::getAppPath('news') .'/templates/subscribelet.php';
		createSubscribelet();
	    ?>
	</dd>
</dl>