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

require_once \OC_App::getAppPath('news') . '/controllers/news.ajax.controller.php';

$controller = new NewsAjaxController();
$controller->loadFeed((int)$_POST['type'], (int)$_POST['id'], 
						(int)$_POST['latestFeedId'], (int)$_POST['latestTimestamp'],
						(int)$_POST['limit']);
