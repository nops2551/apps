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
	protected $api;
	protected $trans;

	public function __construct($request, $api){
		$this->api = $api;
		$this->userId = $api->getUserId();
		$this->appName = $api->getAppName();
		$this->request = $request;
		$this->trans = $api->getTrans();
	}


	/**
	 * @brief lets you access post and get parameters by the index
	 * @param string $key: the key which you want to access in the $_POST or
	 *                     $_GET array. If both arrays store things under the same
	 *                     key, return the value in $_POST
	 * @return: the content of the array
	 */
	protected function params($key){
		$postValue = $this->request->getPOST($key);
		$getValue = $this->request->getGET($key);
		
		if($postValue !== null){
			return $postValue;
		}

		if($getValue !== null){
			return $getValue;
		}
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
