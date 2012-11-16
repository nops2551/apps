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
	protected $request;

	public function __construct($request, $appName){
		$this->userId = $request->getUserId();
		$this->appName = $appName;
		$this->request = $request;
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
	 * @param $templateName the name of the template
	 * @param $arguments an array with arguments in $templateVar => $content
	 * @param $fullPage if true, it will render a full page, otherwise only a part
	 *                  defaults to true
	 */
	protected function render($templateName, $arguments=array(),
							  $fullPage=true){

		$arguments['request'] = $this->request;

		$renderer = new TemplateRenderer($this->appName, $templateName);
		$renderer->setParams($arguments);
		$renderer->setFullPage($fullPage);
		return $renderer->render();
	}


	/**
	 * @brief renders a json success
	 * @param array $params an array which will be converted to JSON
	 */
	protected function renderJSON($params=array()){
		$renderer = new JSONRenderer($this->appName);
		$renderer->setParams($params);
		return $renderer->render();
	}


	/**
	 * @brief renders a json error
	 * @param string $msg: the error message
	 * @param string $file: the file that it occured in
	 * @param array $params an array which will be converted to JSON
	 */
	protected function renderJSONError($msg, $file="", $params=array()){
		$renderer = new JSONRenderer($this->appName);
		$renderer->setParams($params);
		$renderer->setErrorMessage($msg, $file);
		return $renderer->render();
	}


}
