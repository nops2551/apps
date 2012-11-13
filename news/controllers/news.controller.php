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
require_once \OC_App::getAppPath('news') . '/lib/security.php';
require_once \OC_App::getAppPath('news') . '/lib/feedmapper.php';
require_once \OC_App::getAppPath('news') . '/lib/foldermapper.php';


$container = Utils::getDIContainer();
$container['NewsController'] = function($c){
	return new NewsController($c['AppName'], $c['FeedMapper'], $c['FolderMapper'], 
								$c['Security'], $c['UserId']);
};


class NewsController extends Controller {


	/**
	 * @param string $appName: the name of the app
	 * @param FolderMapper $folderMapper: an instance of the folder mapper
	 * @param FeedMapper $feedMapper: an instance of the feed mapper
	 * @param Security $security: the class which runs the security checks
	 * @param string $userId: the id of the user
	 */
	public function __construct($appName, $feedMapper, $folderMapper, $security, $userId){
		parent::__construct($appName, $security, $userId);
		$this->feedMapper = $feedMapper;
		$this->folderMapper = $folderMapper;
		\OCP\App::setActiveNavigationEntry($appName);
	}


	/**
	 * Decides wether to show the feedpage or the firstrun page
	 */
	public function index(){
		if($this->feedMapper->feedCount() > 0){
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

		if(isset($_GET['feedid'])){
			$this->setUserValue('lastViewedFeed', $_GET['feedid']);
			$this->setUserValue('lastViewedFeedType', FeedType::FEED);
		}

		$lastViewedFeedId = $this->getUserValue('lastViewedFeed');
		$lastViewedFeedType = $this->getUserValue('lastViewedFeedType');

		if( $lastViewedFeedId === null || $lastViewedFeedType === null) {
			$this->setUserValue('lastViewedFeed', $this->feedMapper->mostRecent());;
			$this->setUserValue('lastViewedFeedType', FeedType::FEED);
		} else {
			// check if the last selected feed or folder exists
			if( (
					$lastViewedFeedType === FeedType::FEED &&
					$this->feedMapper->findById($lastViewedFeedId) === null
				) ||
				(
					$lastViewedFeedType === FeedType::FOLDER &&
					$this->folderMapper->findById($lastViewedFeedId) === null
				) ){
				$this->setUserValue('lastViewedFeed', $this->feedMapper->mostRecent());;
				$this->setUserValue('lastViewedFeedType', FeedType::FEED);
			}
		}

		$this->render('main');
	}


}
