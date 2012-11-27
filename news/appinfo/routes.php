<?php
/**
* ownCloud - News app
*
* @author Bernhard Posselt
* Copyright (c) 2012 - Bernhard Posselt <nukeawhale@gmail.com>
*
* This file is licensed under the Affero General Public License version 3 or later.
* See the COPYING-README file
*
*/

namespace OCA\News;

require_once \OC_App::getAppPath('news') . '/appinfo/bootstrap.php';

/**
 * Shortcut for calling a controller method and printing the result
 * @param string $controllerName: the name of the controller under which it is
 *                                stored in the DI container
 * @param string $methodName: the method that you want to call
 * @param $urlParams
 * @param bool $disableCSRF: disables the csrf check, defaults to false
 * @param bool $disableAdminCheck: disables the check for adminuser rights
 * @internal param array $params : an array with variables extracted from the routes
 */
function callController($controllerName, $methodName, $urlParams, 
						$disableCSRF=false, $disableAdminCheck=true){
	$container = createDIContainer();
	
	// run security checks
	$security = $container['Security'];
	if($disableCSRF){
		$security->setCSRFCheck(false);	
	}
	if($disableAdminCheck){
		$security->setIsAdminCheck(false);	
	}
	$security->runChecks();

	$controller = $container[$controllerName];
	echo $controller->$methodName($urlParams);
}

/*************************
 * Define your routes here
 */


/**
 * Normal Routes
 */
$this->create('news_index', '/')->action(
	function($params){		
		callController('NewsController', 'index', $params, true);
	}
);


/**
 * AJAX Routes
 */
$this->create('news_ajax_init', '/ajax/init')->action(
	function($params){		
		callController('NewsAjaxController', 'init', $params);
	}
);

$this->create('news_ajax_setshowall', '/ajax/setshowall')->action(
	function($params){		
		callController('NewsAjaxController', 'setShowAll', $params);
	}
);


/**
 * Folders
 */
$this->create('news_ajax_collapsefolder', '/ajax/collapsefolder')->action(
	function($params){		
		callController('NewsAjaxController', 'collapseFolder', $params);
	}
);

$this->create('news_ajax_changefoldername', '/ajax/changefoldername')->action(
	function($params){		
		callController('NewsAjaxController', 'changeFolderName', $params);
	}
);

$this->create('news_ajax_createfolder', '/ajax/createfolder')->action(
	function($params){		
		callController('NewsAjaxController', 'createFolder', $params);
	}
);

$this->create('news_ajax_deletefolder', '/ajax/deletefolder')->action(
	function($params){		
		callController('NewsAjaxController', 'deleteFolder', $params);
	}
);


/**
 * Feeds
 */
$this->create('news_ajax_loadfeed', '/ajax/loadfeed')->action(
	function($params){		
		callController('NewsAjaxController', 'loadFeed', $params);
	}
);

$this->create('news_ajax_deletefeed', '/ajax/deletefeed')->action(
	function($params){		
		callController('NewsAjaxController', 'deleteFeed', $params);
	}
);

$this->create('news_ajax_movefeedtofolder', '/ajax/movefeedtofolder')->action(
	function($params){		
		callController('NewsAjaxController', 'moveFeedToFolder', $params);
	}
);

$this->create('news_ajax_updatefeed', '/ajax/updatefeed')->action(
	function($params){		
		callController('NewsAjaxController', 'updateFeed', $params);
	}
);

$this->create('news_ajax_createfeed', '/ajax/createfeed')->action(
	function($params){		
		callController('NewsAjaxController', 'createFeed', $params);
	}
);


/**
 * Items
 */
$this->create('news_ajax_setitemstatus', '/ajax/setitemstatus')->action(
	function($params){		
		callController('NewsAjaxController', 'setItemStatus', $params);
	}
);

$this->create('news_ajax_setallitemsread', '/ajax/setallitemsread')->action(
	function($params){		
		callController('NewsAjaxController', 'setAllItemsRead', $params);
	}
);

