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
 * Shortcut for calling a controller method
 * @param string $controllerName: the name of the controller under which it is
 *                                stored in the DI container
 * @param string $method: the method that you want to call
 */
function callController($controllerName, $methodName, $params, $disableCSRF=false){
	$container = createDIContainer();
	$controller = $container[$controllerName];
	
	// run security checks
	$security = $container['Security'];
	if($disableCSRF){
		$security->setCSRFCheck(false);	
	}

	$security->runChecks();

	echo $controller->$methodName($params);
}

/*************************
 * Define your routes here
 */


/**
 * Normal Routes
 */
$this->create('index', '/')->action(
	function($params){		
		callController('NewsController', 'index', $params, true);
	}
);


/**
 * AJAX Routes
 */
$this->create('ajax_init', '/ajax/init')->action(
	function($params){		
		callController('NewsAjaxController', 'init', $params);
	}
);


$this->create('ajax_loadfeed', '/ajax/loadfeed')->action(
	function($params){		
		callController('NewsAjaxController', 'loadFeed', $params);
	}
);

$this->create('ajax_setshowall', '/ajax/setshowall')->action(
	function($params){		
		callController('NewsAjaxController', 'setShowAll', $params);
	}
);

$this->create('ajax_collapsefolder', '/ajax/collapsefolder')->action(
	function($params){		
		callController('NewsAjaxController', 'collapseFolder', $params);
	}
);

$this->create('ajax_deletefeed', '/ajax/deletefeed')->action(
	function($params){		
		callController('NewsAjaxController', 'deleteFeed', $params);
	}
);

$this->create('ajax_deletefolder', '/ajax/deletefolder')->action(
	function($params){		
		callController('NewsAjaxController', 'deleteFolder', $params);
	}
);

$this->create('ajax_setitemstatus', '/ajax/setitemstatus')->action(
	function($params){		
		callController('NewsAjaxController', 'setItemStatus', $params);
	}
);

$this->create('ajax_changefoldername', '/ajax/changefoldername')->action(
	function($params){		
		callController('NewsAjaxController', 'changeFolderName', $params);
	}
);

$this->create('ajax_movefeedtofolder', '/ajax/movefeedtofolder')->action(
	function($params){		
		callController('NewsAjaxController', 'moveFeedToFolder', $params);
	}
);

$this->create('ajax_updatefeed', '/ajax/updatefeed')->action(
	function($params){		
		callController('NewsAjaxController', 'updateFeed', $params);
	}
);

$this->create('ajax_createfolder', '/ajax/createfolder')->action(
	function($params){		
		callController('NewsAjaxController', 'createFolder', $params);
	}
);

$this->create('ajax_setallitemsread', '/ajax/setallitemsread')->action(
	function($params){		
		callController('NewsAjaxController', 'setAllItemsRead', $params);
	}
);