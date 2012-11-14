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

require_once \OC_App::getAppPath('news') . '/lib/bootstrap.php';

$controller = $container['NewsAjaxController'];
$controller->collapseFolder((int)$_POST['folderId'], 
								$controller->postParamToBool($_POST['opened']));
