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

/**
 * This file is included before every request
 * It fills the DI container with all needed values
 */
$container = new \Pimple();

/** 
 * CONSTANTS
 */
$container['AppName'] = 'news';


/** 
 * CLASSES
 */
$container['UserId'] = function($c){
	return \OCP\USER::getUser();
};


$container['Trans'] = function($c){
	return \OC_L10N::get($c['AppName']);
};


$container['Security'] = $container->share(function($c) {
	return new Security($c['AppName']);	
});


/** 
 * MAPPERS
 */
$container['ItemMapper'] = $container->share(function($c){
	return new ItemMapper($c['UserId']);
});

$container['FeedMapper'] = $container->share(function($c){
	return new FeedMapper($c['UserId']);
});

$container['FolderMapper'] = $container->share(function($c){
	return new FolderMapper($c['UserId']);
});


/** 
 * CONTROLLERS
 */
$container['NewsController'] = function($c){
	return new NewsController($c['AppName'], $c['FeedMapper'], 
								$c['FolderMapper'], $c['Security'], $c['UserId']);
};

$container['NewsAjaxController'] = function($c){
	return new NewsAjaxController($c['AppName'], $c['FeedMapper'], 
									$c['FolderMapper'], $c['ItemMapper'], 
									$c['Security'], $c['UserId'], $c['Trans']);
};

