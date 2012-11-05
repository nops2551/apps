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


class NewsController extends Controller {


	public function __construct($csrfCheck=true){
		parent::__construct($csrfCheck);
		\OCP\App::setActiveNavigationEntry('news');
	}


	/**
	 * Decides wether to show the feedpage or the firstrun page
	 */
	public function index(){
		$feedMapper = new FeedMapper($this->userId);

		if($feedMapper->feedCount() > 0){
			$this->feedPage();
		} else {
			$this->firstRun();
		}
	}


	public function firstRun(){
		$this->addScript('news');
		$this->addScript('firstrun');
		$this->addStyle('firstrun');
		$this->render('firstrun');
	}


	public function feedPage(){
		$this->add3rdPartyScript('angular-1.0.2/angular');
		$this->add3rdPartyScript('moment.min');
		$this->addScript('app');


		$this->addStyle('news');
		$this->addStyle('settings');

		$folderMapper = new FolderMapper($this->userId);
		$feedMapper = new FeedMapper($this->userId);
		$itemMapper = new ItemMapper($this->userId);

		// if no feed id is passed as parameter, then show the last viewed feed on reload
		$lastViewedFeedId = isset( $_GET['feedid'] ) ? $_GET['feedid'] : (int)$this->getUserValue('lastViewedFeed');
		$lastViewedFeedType = isset( $_GET['feedid'] ) ? FeedType::FEED : (int)$this->getUserValue('lastViewedFeedType');
		
	$showAll = $this->getUserValue('showAll');

		if( $lastViewedFeedId === null || $lastViewedFeedType === null) {
			$lastViewedFeedId = $feedMapper->mostRecent();
		} else {
			// check if the last selected feed or folder exists
			if( (
					$lastViewedFeedType === FeedType::FEED &&
					$feedMapper->findById($lastViewedFeedId) === null
				) ||
				(
					$lastViewedFeedType === FeedType::FOLDER &&
					$folderMapper->findById($lastViewedFeedId) === null
				) ){
				$lastViewedFeedId = $feedMapper->mostRecent();
			}
		}

		$feeds = $folderMapper->childrenOfWithFeeds(0);
		$folderForest = $folderMapper->childrenOf(0); //retrieve all the folders
		$starredCount = $itemMapper->countEveryItemByStatus(StatusFlag::IMPORTANT);
		$items = $itemMapper->getItems($lastViewedFeedType, $lastViewedFeedId, $showAll);

		$params = array(
			'allfeeds' => $feeds,
			'folderforest' => $folderForest,
			'showAll' => $showAll,
			'lastViewedFeedId' => $lastViewedFeedId,
			'lastViewedFeedType' => $lastViewedFeedType,
			'starredCount' => $starredCount,
			'items' => $items
		);

		$this->render('main', $params, array('items' => true));
	}


}
