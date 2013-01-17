<?php
/**
* ownCloud - News app
*
* @author Alessandro Cosentino
* Copyright (c) 2012 - Alessandro Cosentino <cosenal@gmail.com>
*
* This file is licensed under the Affero General Public License version 3 or later.
* See the COPYING-README file
*
*/


namespace OCA\News;


class OPMLImporter {


	private $successCount;
	private $eventSource;

	public function __construct($eventSource){
		$this->eventSource = $eventSource;
	}


	public function import($parsed, $onFolderAdd, $onFeedAdd){
		$this->successCount = importList($parsed, 0, $onFolderAdd, $onFeedAdd);
	}


	public function getSuccessfullyImportedCount(){
		return $this->successCount;
	}


}



function importFeed($feedurl, $folderid, $feedtitle, $onFeedAdd) {

	$feedmapper = new FeedMapper();
	$feedid = $feedmapper->findIdFromUrl($feedurl);

	if ($feedid === null) {
		$feed = Utils::slimFetch($feedurl);
		
		if ($feed !== null) {
		      $feed->setTitle($feedtitle); //we want the title of the feed to be the one from the opml file
		      $feedid = $feedmapper->save($feed, $folderid);
		      $onFeedAdd($feed);
		}
	} else {
		\OCP\Util::writeLog('news','ajax/importopml.php: This feed is already here: '. $feedurl, \OCP\Util::WARN);
		return true;
	}

	if($feed === null || !$feedid) {
		\OCP\Util::writeLog('news','ajax/importopml.php: Error adding feed: '. $feedurl, \OCP\Util::ERROR);
		return false;
	}

	return true;
}

function importFolder($name, $parentid, $onFolderAdd) {
	
	$foldermapper = new FolderMapper();

	if($parentid != 0) {
	    $folder = new Folder($name, null, $foldermapper->find($parentid));
	} else {
	    $folder = new Folder($name);
	}

	$folderid = $foldermapper->save($folder);

	$onFolderAdd($folder);
	
	if(!$folderid) {
		\OCP\Util::writeLog('news','ajax/importopml.php: Error adding folder' . $name, \OCP\Util::ERROR);
		return null;
	}

	return $folderid;
}


function importList($data, $parentid, $onFolderAdd, $onFeedAdd) {
	$countsuccess = 0;
	foreach($data as $collection) {
		if ($collection instanceOf Feed) {
			$feedurl = $collection->getUrl();
			$feedtitle = $collection->getTitle();
			if (importFeed($feedurl, $parentid, $feedtitle, $onFeedAdd)) {
				$countsuccess++;
			}
		}
		else if ($collection instanceOf Folder) {
			$folderid = importFolder($collection->getName(), $parentid, $onFolderAdd);
			if ($folderid) {
				$children = $collection->getChildren();
				$countsuccess += importList($children, $folderid);
			}
		}
		else {
			\OCP\Util::writeLog('news','ajax/importopml.php: Error importing OPML',\OCP\Util::ERROR);
		}
	}
	return $countsuccess;
}