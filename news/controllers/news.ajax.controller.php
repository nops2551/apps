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

require_once \OC_App::getAppPath('news') . '/controllers/controller.php';


class NewsAjaxController extends Controller {


	/**
	 * Does all the security checks
	 * @param bool $csrfCheck pass false to disable the csrf check. true by default
	 */
	public function __construct($csrfCheck=true){
		parent::__construct($csrfCheck);
	}


	/**
	 * @brief turns a post parameter which got a boolean from javascript to 
	 * a boolean in PHP
	 * @param string $param the post parameter that should be turned into a bool
	 * @return a PHP boolean
	 */
	private function postParamToBool($param){
		if($param === 'false') {
			return false;
		} else {
			return true;
		}
	}


	/**
	 * This turns a folder result into an array which can be sent to the client
	 * as JSON
	 * @param array $folders the database query result for folders
	 * @return an array ready for sending as JSON
	 */
	private function foldersToArray($folders){
		$foldersArray = array();
		foreach($folders as $folder){
			if($folder instanceof \OCA\News\Folder){
				 array_push($foldersArray, array(
					'id' => (int)$folder->getId(),
					'name' => $folder->getName(),
					'open' => $folder->getOpened()==="1",
					'hasChildren' => count($folder->getChildren()) > 0,
					'show' => true
					)
				);
			}
		}
		return $foldersArray;
	}


	/**
	 * This turns a feed result into an array which can be sent to the client
	 * as JSON
	 * @param array $feeds the database query result for feeds
	 * @return an array ready for sending as JSON
	 */
	private function feedsToArray($feeds){
		$itemMapper = new \OCA\News\ItemMapper($this->userId);

		$feedsArray = array();
		foreach($feeds as $feed){
			 array_push($feedsArray, array(
				'id' => (int)$feed['id'],
				'name' => $feed['title'],
				'unreadCount' => $itemMapper->getUnreadCount(\OCA\News\FeedType::FEED, $feed['id']),
				'folderId' => (int)$feed['folderid'],
				'show' => true,
				'icon' => 'url(' . $feed['favicon'] .')',
				'url' => $feed['url']
				)
			);
		}
		return $feedsArray;
	}


	/**
	 * This is being called when the app starts and all feeds
	 * and folders are requested
	 */
	public function init(){
		$folderMapper = new \OCA\News\FolderMapper($this->userId);
		$folders = $folderMapper->childrenOfWithFeeds(0);
		$foldersArray = $this->foldersToArray($folders);

		$feedMapper = new \OCA\News\FeedMapper($this->userId);
		$feeds = $feedMapper->findAll();
		$feedsArray = $this->feedsToArray($feeds);

		$activeFeed = array();
		$activeFeed['id'] = (int)$this->getUserValue('lastViewedFeed');
		$activeFeed['type'] = (int)$this->getUserValue('lastViewedFeedType');

		$showAll = $this->getUserValue('showAll') === "1";

		$itemMapper = new \OCA\News\ItemMapper($this->userId);
		$starredCount = $itemMapper->getUnreadCount(\OCA\News\FeedType::STARRED, 0);

		$result = array('data' => array(
			'folders' => $foldersArray,
			'feeds' => $feedsArray,
			'activeFeed' => $activeFeed,
			'showAll' => $showAll,
			'userId' => $this->userId,
			'starredCount' => $starredCount
		));

		$this->renderJSON($result);
	}


	/**
	 * Used for setting the showAll value from a post request
	 * @param string $showAll a string with either "true" or "false" sets the showAll
	 */
	public function setShowAll($showAll){
		$showAll = $this->postParamToBool($showAll);
		$this->setUserValue('showAll', $showAll);
		$this->renderJSON();
	}



}
