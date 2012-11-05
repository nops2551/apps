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
		parent::__construct();
		\OCP\JSON::checkAppEnabled('news');
		\OCP\JSON::checkLoggedIn();
		if($csrfCheck){
			\OCP\JSON::callCheck();	
		}
		session_write_close();
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
	 * Used for setting the showAll value from a post request
	 * @param string $showAll a string with either "true" or "false" sets the showAll
	 */
	public function setShowAll($showAll){
		$showAll = $this->postParamToBool($showAll);
		$this->setUserValue('showAll', $showAll);
		$this->renderJSON();
	}



}
