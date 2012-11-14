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

	private $feedMapper;
	private $folderMapper;
	private $itemMapper;
	private $trans;

	/**
	 * @param Request $request: the object with the request instance
	 * @param string $appName: the name of the app
	 * @param FeedMapper $feedMapepr an instance of the feed mapper
	 * @param FolderMapper $folderMapper an instance of the folder mapper
	 * @param ItemMapper $itemMapper an instance of the item mapper
	 * @param $l: an instance of the translation object
	 */
	public function __construct($request, $appName, $feedMapper, $folderMapper, 
								$itemMapper, $trans){
		parent::__construct($request, $appName);
		$this->feedMapper = $feedMapper;
		$this->folderMapper = $folderMapper;
		$this->itemMapper = $itemMapper;
		$this->trans = $trans;
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
				'id' => (int)$feed->getId(),
				'name' => $feed->getTitle(),
				'unreadCount' => $this->itemMapper->getUnreadCount(FeedType::FEED, 
																$feed->getId()),
				'folderId' => (int)$feed->getFolderId(),
				'show' => true,
				'icon' => 'url(' . $feed->getFavicon() .')',
				'url' => $feed->getUrl()
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

		return $this->renderJSON($result);
	}


	/**
	 * loads the next X feeds from the server
	 */
	public function loadFeed(){
		$feedType = (int)$this->request->post('type');
		$feedId = (int)$this->request->post('id');
		$latestFeedId = (int)$this->request->post('latestFeedId');
		$latestTimestamp = (int)$this->request->post('latestTimestamp');
		$limit = (int)$this->request->post('limit');

		// FIXME: integrate latestFeedId, latestTimestamp and limit
		$this->setUserValue('lastViewedFeed', $feedId);
		$this->setUserValue('lastViewedFeedType', $feedType);

		$showAll = $this->getUserValue('showAll');

		$items = $this->itemMapper->getItems($feedType, $feedId, $showAll);
		$unreadCount = $this->itemMapper->getUnreadCount($feedType, $feedId);

		$itemsArray = $this->itemsToArray($items);

		$result = array('items' => $itemsArray);

		return $this->renderJSON($result);

	}


	/**
	 * Used for setting the showAll value from a post request
	 */
	public function setShowAll(){       
		$feedType = $this->request->post('showAll');
		$this->setUserValue('showAll', $showAll);
		return $this->renderJSON();
	}


	/**
	 * Used for setting the showAll value from a post request
	 */
	public function collapseFolder(){
		$folderId = (int)$this->request->post('folderId');
		$opened = $this->postParamToBool($this->request->post('opened'));

		$folder = $this->folderMapper->find($folderId);
		$folder->setOpened($opened);
		$this->folderMapper->update($folder);
		return $this->renderJSON();
	}


	/**
	 * Deletes a feed
	 */
	public function deleteFeed(){
		$feedId = (int)$this->request->post('feedId');
		$this->feedMapper->deleteById($feedId);
		return $this->renderJSON();
	}


	/**
	 * Deletes a folder
	 */
	public function deleteFolder(){
		$folderId = (int)$this->request->post('folderId');
		$this->folderMapper->deleteById($folderId);
		return $this->renderJSON();
	}


	/**
	 * Sets the status of an item
	 */
	public function setItemStatus(){
		$itemId = (int)$this->request->post('itemId');
		$status = $this->request->post('status');
		$item = $this->itemMapper->findById($itemId);
		
		switch ($status) {
			case 'read':
				$item->setRead();
				break;
			case 'unread':
				$item->setUnread();
				break;
			case 'important':
				$item->setImportant();
				break;
			case 'unimportant':
				$item->setUnimportant();
				break;
			default:
				exit();
				break;
		}

		$this->itemMapper->update($item);
		return $this->renderJSON();
	}


	/**
	 * Changes the name of a folder
	 */
	public function changeFolderName(){
		$folderId = (int)$this->request->post('folderId');
		$folderName = $this->request->post('folderName');
		$folder = $this->folderMapper->find($folderId);
		$folder->setName($folderName);
		$this->folderMapper->update($folder);
		return $this->renderJSON();
	}


	/**
	 * Moves a feed to a new folder
	 */
	public function moveFeedToFolder(){
		$feedId = (int)$this->request->post('feedId');
		$folderId = (int)$this->request->post('folderId');
		$feed = $this->feedMapper->findById($feedId);
		if($folderId === 0) {
			$this->feedMapper->save($feed, $folderId);
		} else {
			$folder = $folderMapper->find($folderId);
			if(!$folder){
				$msgString = 'Can not move feed %s to folder %s';
				$msg = $this->trans($msgString, array($feedId, $folderId));
				return $this->renderJSONError($msg, __FILE__);
			}
			$this->feedMapper->save($feed, $folder->getId());
		}
		return $this->renderJSON();
	}


	/**
	 * Pulls new feed items from its url
	 */
	public function updateFeed(){
		$feedId = (int)$this->request->post('feedId');
		$feed = $this->feedMapper->findById($feedId);
		$newFeed = Utils::fetch($feed->getUrl());

		$newFeedId = false;
		if ($newFeed !== null) {
		    $newFeedId = $this->feedMapper->save($newFeed, $feed->getFolderId());
		}

		if($newFeedId){
			$feeds = array($this->feedMapper->findById($feedId));
			$feedsArray = array(
				'feeds' => $this->feedsToArray($feeds)
			);
			return $this->renderJSON($feedsArray);
		} else {
			$msgString = 'Error updating feed %s';
			$msg = $this->trans($msgString, array($feed->getUrl()));
			return $this->renderJSONError($msg, __FILE__);
		}

	}


	/**
	 * Creates a new folder
	 */
	public function createFolder(){
		$folderName = (int)$this->request->post('folderName');
		$folder = new Folder($folderName);
		$folderId = $this->folderMapper->save($folder);
		$folders = array($this->folderMapper->findById($folderId));
		$foldersArray = array(
			'folders' => $this->foldersToArray($feeds)
		);
		return $this->renderJSON($foldersArray);
	}



	/**
	 * Sets all items read that are older than the current transmitted 
	 * dates and ids
	 */
	public function setAllItemsRead($feedId, $mostRecentItemId){
		$feedId = (int)$this->request->post('feedId');
		$mostRecentItemId = (int)$this->request->post('mostRecentItemId');

		$feed = $this->feedMapper->findById($feedId);

		if($feed){
			$this->itemMapper->markAllRead($feed->getId(), $mostRecentItemId);

			$feeds = array($this->feedMapper->findById($feed->getId()));
			$feedsArray = array(
				'feeds' => $this->feedsToArray($feeds)
			);
			return $this->renderJSON($feedsArray);		
		}

	}


}
