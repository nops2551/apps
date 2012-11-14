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
 * Class which handles all ajax calls
 */
class NewsAjaxController extends Controller {


	/**
	 * @param string $appName: the name of the app
	 * @param FeedMapper $feedMapepr an instance of the feed mapper
	 * @param FolderMapper $folderMapper an instance of the folder mapper
	 * @param ItemMapper $itemMapper an instance of the item mapper
	 * @param Security $security: the class which runs the security checks
	 * @param string $userId: the id of the user
	 */
	public function __construct($appName, $feedMapper, $folderMapper, 
								$itemMapper, $security, $userId){
		parent::__construct($appName, $security, $userId);
		$this->feedMapper = $feedMapper;
		$this->folderMapper = $folderMapper;
		$this->itemMapper = $itemMapper;
	}


	/**
	 * @brief turns a post parameter which got a boolean from javascript to 
	 * a boolean in PHP
	 * @param string $param the post parameter that should be turned into a bool
	 * @return a PHP boolean
	 */
	public function postParamToBool($param){
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
		$feedsArray = array();
		foreach($feeds as $feed){
			 array_push($feedsArray, array(
				'id' => (int)$feed['id'],
				'name' => $feed['title'],
				'unreadCount' => $this->itemMapper->getUnreadCount(\OCA\News\FeedType::FEED, 
																$feed['id']),
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
	 * This turns an items result into an array which can be sent to the client
	 * as JSON
	 * @param array $items the database query result for items
	 * @return an array ready for sending as JSON
	 */
	private function itemsToArray($items){
		$itemsArray = array();
		foreach($items as $item){

			 array_push($itemsArray, array(
				'id' => (int)$item->getId(),
				'title' => $item->getTitle(),
				'isRead' => (bool)$item->isRead(),
				'isImportant' => (bool)$item->isImportant(),
				'feedId' => (int)$item->getFeedId(),
				'feedTitle' => $item->getFeedTitle(),
				'date' => (int)$item->getDate(),
				'body' => $item->getBody(),
				'author' => $item->getAuthor(),
				'url' => $item->getUrl()
				)
			);
		}
		return $itemsArray;
	}


	/**
	 * This is being called when the app starts and all feeds
	 * and folders are requested
	 */
	public function init(){
		$folders = $this->folderMapper->childrenOfWithFeeds(0);
		$foldersArray = $this->foldersToArray($folders);

		$feeds = $this->feedMapper->findAll();
		$feedsArray = $this->feedsToArray($feeds);

		$activeFeed = array();
		$activeFeed['id'] = (int)$this->getUserValue('lastViewedFeed');
		$activeFeed['type'] = (int)$this->getUserValue('lastViewedFeedType');

		$showAll = $this->getUserValue('showAll') === "1";

		$starredCount = $this->itemMapper->getUnreadCount(\OCA\News\FeedType::STARRED, 0);

		$result = array(
			'folders' => $foldersArray,
			'feeds' => $feedsArray,
			'activeFeed' => $activeFeed,
			'showAll' => $showAll,
			'userId' => $this->userId,
			'starredCount' => $starredCount
		);

		$this->renderJSON($result);
	}


	/**
	 * loads the next X feeds from the server
	 * @param int $feedType the type of the feed
	 * @param int $feedId the id of the feed
	 * @param int $latestFeedId the it of the latest feed that the client has for
	 *                          this type
	 * @param int $latestTimestamp the timestamp of the latest feed that the 
	 *                             client for this type client has
	 * @param int $limit the amount of items that should be loaded, defaults to 20
	 */
	public function loadFeed($feedType, $feedId, $latestFeedId, $latestTimestamp,
								$limit=20){
		// FIXME: integrate latestFeedId, latestTimestamp and limit
		$this->setUserValue('lastViewedFeed', $feedId);
		$this->setUserValue('lastViewedFeedType', $feedType);

		$showAll = $this->getUserValue('showAll');

		$items = $this->itemMapper->getItems($feedType, $feedId, $showAll);
		$unreadCount = $this->itemMapper->getUnreadCount($feedType, $feedId);

		$itemsArray = $this->itemsToArray($items);

		$result = array('items' => $itemsArray);

		$this->renderJSON($result);

	}


	/**
	 * Used for setting the showAll value from a post request
	 * @param bool $showAll sets the value
	 */
	public function setShowAll($showAll){		
		$this->setUserValue('showAll', $showAll);
		$this->renderJSON();
	}


	/**
	 * Used for setting the showAll value from a post request
	 * @param int $folderId the id of the folder that we want to open or collapse
	 * @param bool $opened sets the folder opened or collapsed
	 */
	public function collapseFolder($folderId, $opened){
		$folder = $this->folderMapper->find($folderId);
		$folder->setOpened($opened);
		$this->folderMapper->update($folder);
		$this->renderJSON();
	}


	/**
	 * Deletes a feed
	 * @param int $feedId the id of the feed that should be deleted
	 */
	public function deleteFeed($feedId){
		$this->feedMapper->deleteById($feedId);
		$this->renderJSON();
	}


	/**
	 * Deletes a folder
	 * @param int $folderId the id of the folder that should be deleted
	 */
	public function deleteFolder($folderId){
		$this->folderMapper->deleteById($folderId);
		$this->renderJSON();
	}


}
