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

class Controller {

	protected $userId;
	protected $appName;

	public function __construct($appName, $security, $userId){
		$this->userId = $userId;
		$this->appName = $appName;
		$this->safeParams = array();

		$security->ensure();
	}


	protected function addScript($name){
		\OCP\Util::addScript($this->appName, $name);
	}


	protected function addStyle($name){
		\OCP\Util::addStyle($this->appName, $name);
	}


	protected function add3rdPartyScript($name){
		\OCP\Util::addScript($this->appName . '/3rdparty', $name);
	}


	protected function add3rdPartyStyle($name){
		\OCP\Util::addStyle($this->appName . '/3rdparty', $name);
	}


	/**
	 * Shortcut for setting a user defined value
	 * @param $key the key under which the value is being stored
	 * @param $value the value that you want to store
	 */
	protected function setUserValue($key, $value){
		\OCP\Config::setUserValue($this->userId, $this->appName, $key, $value);
	}


	/**
	 * Shortcut for getting a user defined value
	 * @param $key the key under which the value is being stored
	 */
	protected function getUserValue($key){
		return \OCP\Config::getUserValue($this->userId, $this->appName, $key);
	}


	/**
	 * Binds variables to the template and prints it
	 * The following values are always assigned: userId, trans
	 * @param $arguments an array with arguments in $templateVar => $content
	 * @param $template the name of the template
	 * @param $safeParams template parameters which should not be escaped
	 * @param $fullPage if true, it will render a full page, otherwise only a part
	 *                  defaults to true
	 */
	protected function render($template, $arguments=array(), $safeParams=array(),
							  $fullPage=true){

		if($fullPage){
			$template = new \OCP\Template($this->appName, $template, 'user');
		} else {
			$template = new \OCP\Template($this->appName, $template);
		}

		foreach($arguments as $key => $value){
			if(array_key_exists($key, $safeParams)) {
				$template->assign($key, $value, false);
			} else {
				$template->assign($key, $value);
			}

		}

		$template->assign('userId', $this->userId);
		$template->printPage();
	}


	/**
	 * @brief renders a json success
	 * @param array $params an array which will be converted to JSON
	 */
	protected function renderJSON($params=array()){
		$data = array('data' => $params);
		\OCP\JSON::success($data);	
	}


}
