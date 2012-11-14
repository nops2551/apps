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


/**
 * Encapsulates user id, $_GET and $_POST arrays for better testability
 */
class Request {

	private $get;
	private $post;
	private $userId;

	/**
	 * @param string $userId: the id of the current user
	 * @param array $get: the $_GET array
	 * @param array $post: the $_POST array
	 */
	public function __construct($userId, $get=array(), $post=array()) {
		$this->get = $get;
		$this->post = $post;
		$this->userId = $userId;
	}


	/**
	 * Returns the get value or the default if not found
	 * @param string $key: the array key that should be looked up
	 * @param string $default: if the key is not found, return this value
	 * @return the value of the stored array
	 */
	public function get($key, $default=null){
		if(isset($this->get[$key])){
			return $this->get[$key];
		} else {
			return $default;
		}
	}


	/**
	 * Returns the get value or the default if not found
	 * @param string $key: the array key that should be looked up
	 * @param string $default: if the key is not found, return this value
	 * @return the value of the stored array
	 */
	public function post($key, $default=null){
		if(isset($this->post[$key])){
			return $this->post[$key];
		} else {
			return $default;
		}
	}


	/**
	 * Returns the user id
	 * @return the value of the stored user id
	 */
	public function getUserId(){
		return $this->userId;
	}

}
