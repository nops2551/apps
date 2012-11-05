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

	public function __construct(){
		parent::__construct();
		\OCP\JSON::checkLoggedIn();
		\OCP\JSON::checkAppEnabled('news');
		\OCP\JSON::callCheck();
		session_write_close();
	}


	public function userSettings($showAll){
		if($showAll === 'false') {
			$showAll = false;
		} else {
			$showAll = true;
		}
		$this->setUserValue('showAll', $showAll);
	}



}
