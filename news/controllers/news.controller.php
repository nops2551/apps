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


class NewsController extends Controller {

	private $feedMapper;
	private $folderMapper;

	/**
	 * @param Request $request: the object with the request instance
	 * @param string $appName: the name of the app
	 * @param FolderMapper $folderMapper: an instance of the folder mapper
	 * @param FeedMapper $feedMapper: an instance of the feed mapper
	 */
	public function __construct($request, $appName, $feedMapper, $folderMapper, $security, $userId){
		parent::__construct($request, $appName);
		$this->feedMapper = $feedMapper;
		$this->folderMapper = $folderMapper;
		\OCP\App::setActiveNavigationEntry($appName);
	}


	/**
	 * Decides wether to show the feedpage or the firstrun page
	 */
	public function index(){

		if($this->feedMapper->feedCount() > 0){
			return $this->feedPage();
		} else {
			return $this->firstRun();
		}
	}


	private function firstRun(){
		$this->addScript('news');
		$this->addScript('firstrun');
		$this->addStyle('firstrun');
		return $this->render('firstrun');
	}


	private function feedPage(){
		$this->add3rdPartyScript('angular-1.0.2/angular');
		$this->add3rdPartyScript('moment.min');
		$this->addScript('app');
		$this->addStyle('news');
		$this->addStyle('settings');

		if($this->request->get('feedid')){	
			$this->setUserValue('lastViewedFeed', $this->request->get('feedid'));
			$this->setUserValue('lastViewedFeedType', FeedType::FEED);
		}

		$lastViewedFeedId = $this->getUserValue('lastViewedFeed');
		$lastViewedFeedType = $this->getUserValue('lastViewedFeedType');

		if( $lastViewedFeedId === null || $lastViewedFeedType === null) {
			$this->setUserValue('lastViewedFeed', $this->feedMapper->mostRecent());;
			$this->setUserValue('lastViewedFeedType', FeedType::FEED);

		} else {
			// check if the last selected feed or folder exists
			if(($lastViewedFeedType === FeedType::FEED &&
				$this->feedMapper->findById($lastViewedFeedId) === null) ||
				($lastViewedFeedType === FeedType::FOLDER &&
					$this->folderMapper->findById($lastViewedFeedId) === null)){
				$this->setUserValue('lastViewedFeed', $this->feedMapper->mostRecent());;
				$this->setUserValue('lastViewedFeedType', FeedType::FEED);
			}
		}

		return $this->render('main');
	}


}
