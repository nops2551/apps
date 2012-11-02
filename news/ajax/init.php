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
//\OCP\JSON::callCheck();
session_write_close();


$userid = \OCP\USER::getUser();

$folderMapper = new OCA\News\FolderMapper($userId);
$folders = $folderMapper->childrenOfWithFeeds(0);

$foldersArray = array();
foreach($folders as $folder){
	if($folder instanceof OCA\News\Folder){
		 array_push($foldersArray, array(
			'id' => (int)$folder->getId(),
			'name' => $folder->getName(),
			'opened' => $folder->getOpened(),
			'hasChildren' => count($folder->getChildren()) > 0
			)
		);
	}
}

$feedMapper = new OCA\News\FeedMapper($userId);
$feeds = $feedMapper->findAll();

$itemMapper = new OCA\News\ItemMapper($userId);

$feedsArray = array();
foreach($feeds as $feed){
	 array_push($feedsArray, array(
		'id' => (int)$feed['id'],
		'name' => $feed['title'],
		'unreadCount' => (int)$itemMapper->countAllStatus($feed['id'], OCA\News\StatusFlag::UNREAD),
		'folderId' => (int)$feed['folderid'],
		'show' => true,
		'icon' => $feed['favicon'],
		'url' => $feed['url']
		)
	);
}

$activeFeed = array();
$activeFeed['id'] = OCP\Config::getUserValue($userId, 'news', 'lastViewedFeed');
$activeFeed['type'] = OCP\Config::getUserValue($userId, 'news', 'lastViewedFeedType');

$showAll = (bool)OCP\Config::getUserValue($userId, 'news', 'showAll');

OCP\JSON::success(array(
	'folders' => $foldersArray,
	'feeds' => $feedsArray,
	'activeFeed' => $activeFeed,
	'showAll' => $showAll
));
