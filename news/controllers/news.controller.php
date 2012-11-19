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
	 * @param string $api: an instance of the api wrapper object
	 * @param FolderMapper $folderMapper: an instance of the folder mapper
	 * @param FeedMapper $feedMapper: an instance of the feed mapper
	 */
	public function __construct($request, $api, $feedMapper, $folderMapper){
		parent::__construct($request, $api);
		$this->feedMapper = $feedMapper;
		$this->folderMapper = $folderMapper;
		$this->api->activateNavigationEntry();
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
		$this->api->addScript('news');
		$this->api->addScript('firstrun');
		$this->api->addStyle('firstrun');
		return $this->render('firstrun');
	}


	private function feedPage(){
		$this->api->add3rdPartyScript('angular-1.0.2/angular');
		$this->api->add3rdPartyScript('moment.min');
		$this->api->addScript('app');
		$this->api->addStyle('news');


		if($this->params('feedid')){	
			$this->api->setUserValue('lastViewedFeed', $this->params('feedid'));
			$this->api->setUserValue('lastViewedFeedType', FeedType::FEED);
		}

		$lastViewedFeedId = $this->api->getUserValue('lastViewedFeed');
		$lastViewedFeedType = $this->api->getUserValue('lastViewedFeedType');

		if( $lastViewedFeedId === null || $lastViewedFeedType === null) {
			$this->api->setUserValue('lastViewedFeed', $this->feedMapper->mostRecent());;
			$this->api->setUserValue('lastViewedFeedType', FeedType::FEED);

		} else {
			// check if the last selected feed or folder exists
			if(($lastViewedFeedType === FeedType::FEED &&
				$this->feedMapper->findById($lastViewedFeedId) === null) ||
				($lastViewedFeedType === FeedType::FOLDER &&
					$this->folderMapper->findById($lastViewedFeedId) === null)){
				$this->api->setUserValue('lastViewedFeed', $this->feedMapper->mostRecent());;
				$this->api->setUserValue('lastViewedFeedType', FeedType::FEED);
			}
		}

		return $this->render('main');
	}


}
