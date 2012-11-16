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

interface Renderer {
	function render();
}


class TemplateRenderer implements Renderer {

	private $name;
	private $params;
	private $appName;
	private $fullPage;

	public function __construct($appName, $name) {
		$this->name = $name;
		$this->appName = $appName;
		$this->params = array();
		$this->fullPage = true;
	}


	public function setParams($params){
		$this->params = $params;
	}


	public function setFullPage($fullPage){
		$this->fullPage = $fullPage;
	}


	public function render(){
		if($this->fullPage){
			$template = new \OCP\Template($this->appName, $this->name, 'user');
		} else {
			$template = new \OCP\Template($this->appName, $this->name);
		}

		foreach($this->params as $key => $value){
			$template->assign($key, $value, false);
		}

		return $template->fetchPage();
	}

}



class JSONRenderer implements Renderer {

	private $name;
	private $data;
	private $appName;

	public function __construct($appName) {
		$this->appName = $appName;
		$this->data = array();
		$this->error = false;
	}


	public function setParams($params){
		$this->data['data'] = $params;
	}


	public function setErrorMessage($msg, $file){
		$this->error = true;
		$this->data['msg'] = $msg;

		\OCP\Util::writeLog($this->appName, $file . ': ' . $msg, \OCP\Util::ERROR);
	}


	public function render(){
		
		ob_start();

		if($this->error){
			\OCP\JSON::error($this->data);
		} else {
			\OCP\JSON::success($this->data);
		}
			
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

}