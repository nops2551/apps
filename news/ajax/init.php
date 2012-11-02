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

/**
 * This file is being called when the app starts and all feeds
 * and folders are requested
 */

\OCP\JSON::checkLoggedIn();
\OCP\JSON::checkAppEnabled('news');
\OCP\JSON::callCheck();
session_write_close();


$userId = \OCP\USER::getUser();

$folderMapper = new OCA\News\FolderMapper($userId);
$folders = $folderMapper->childrenOfWithFeeds(0);

$foldersArray = array();
foreach($folders as $folder){
	if($folder instanceof OCA\News\Folder){
		 array_push($foldersArray, array(
			'id' => (int)$folder->getId(),
			'name' => $folder->getName(),
			'open' => $folder->getOpened()=="1",
			'hasChildren' => count($folder->getChildren()) > 0,
			'show' => true
			)
		);
	}
}

$itemMapper = new OCA\News\ItemMapper($userId);
$items = 


$feedMapper = new OCA\News\FeedMapper($userId);
$feeds = $feedMapper->findAll();

$feedsArray = array();
foreach($feeds as $feed){
	 array_push($feedsArray, array(
		'id' => (int)$feed['id'],
		'name' => $feed['title'],
		'unreadCount' => (int)$itemMapper->countAllStatus($feed['id'], OCA\News\StatusFlag::UNREAD),
		'folderId' => (int)$feed['folderid'],
		'show' => true,
		'icon' => 'url(' . $feed['favicon'] .')',
		'url' => $feed['url']
		)
	);
}

$activeFeed = array();
$activeFeed['id'] = (int)OCP\Config::getUserValue($userId, 'news', 'lastViewedFeed');
$activeFeed['type'] = (int)OCP\Config::getUserValue($userId, 'news', 'lastViewedFeedType');

$showAll = OCP\Config::getUserValue($userId, 'news', 'showAll');

OCP\JSON::success(array('data' => array(
	'folders' => $foldersArray,
	'feeds' => $feedsArray,
	'activeFeed' => $activeFeed,
	'showAll' => $showAll,
	'userId' => $userId
)));
