<?php

/**
* ownCloud - News app
*
* @author Alessandro Cosentino
* Copyright (c) 2012 - Alessandro Cosentino <cosenal@gmail.com>
*
* This file is licensed under the Affero General Public License version 3 or later.
* See the COPYING-README file
*
*/

namespace OCA\News;

require_once \OC_App::getAppPath('news') . '/lib/bootstrap.php';

// routes
if(isset($_GET['jstest'])){
	$container['Security']->setCSRFCheck(false);
	$controller = $container['NewsController'];
	$controller->javascriptTests();
} else {
	$container['Security']->setCSRFCheck(false);
	$controller = $container['NewsController'];
	$controller->index();
}