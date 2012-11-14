<?php
/**
* ownCloud - News app
*
* @author Bernhard Posselt, Alessandro Copyright
* Cosentino (c) 2012 - Bernhard Posselt <nukeawhale@gmail.com>
*                      Alessandro Cosentino <cosenal@gmail.com>
*
* This file is licensed under the Affero General Public License version 3 or later.
* See the COPYING-README file
*
*/

namespace OCA\News;

\OC::$CLASSPATH['Pimple'] = 'apps/news/3rdparty/Pimple/Pimple.php';

\OC::$CLASSPATH['OC_Search_Provider_News'] = 'apps/news/lib/search.php';

\OC::$CLASSPATH['OCA\News\Backgroundjob'] = 'apps/news/lib/backgroundjob.php';

\OC::$CLASSPATH['OCA\News\Share_Backend_News_Item'] = 'apps/news/lib/share/item.php';

\OC::$CLASSPATH['OCA\News\StatusFlag'] = 'apps/news/lib/item.php';
\OC::$CLASSPATH['OCA\News\Item'] = 'apps/news/lib/item.php';
\OC::$CLASSPATH['OCA\News\Collection'] = 'apps/news/lib/collection.php';
\OC::$CLASSPATH['OCA\News\Feed'] = 'apps/news/lib/feed.php';
\OC::$CLASSPATH['OCA\News\Folder'] = 'apps/news/lib/folder.php';
\OC::$CLASSPATH['OCA\News\FeedType'] = 'apps/news/lib/feedtypes.php';

\OC::$CLASSPATH['OCA\News\FeedMapper'] = 'apps/news/lib/feedmapper.php';
\OC::$CLASSPATH['OCA\News\ItemMapper'] = 'apps/news/lib/itemmapper.php';
\OC::$CLASSPATH['OCA\News\FolderMapper'] = 'apps/news/lib/foldermapper.php';

\OC::$CLASSPATH['OCA\News\Utils'] = 'apps/news/lib/utils.php';
\OC::$CLASSPATH['OCA\News\Security'] = 'apps/news/lib/security.php';
\OC::$CLASSPATH['OCA\News\Request'] = 'apps/news/lib/request.php';

\OC::$CLASSPATH['OCA\News\TemplateRenderer'] = 'apps/news/lib/renderers.php';
\OC::$CLASSPATH['OCA\News\JSONRenderer'] = 'apps/news/lib/renderers.php';
\OC::$CLASSPATH['OCA\News\Controller'] = 'apps/news/controllers/controller.php';
\OC::$CLASSPATH['OCA\News\NewsController'] = 'apps/news/controllers/news.controller.php';
\OC::$CLASSPATH['OCA\News\NewsAjaxController'] = 'apps/news/controllers/news.ajax.controller.php';


/**
 * @return a new DI container with prefilled values for the news app
 */
function createDIContainer(){
	$newsContainer = new \Pimple();

	/** 
	 * CONSTANTS
	 */
	$newsContainer['AppName'] = 'news';


	/** 
	 * CLASSES
	 */
	$newsContainer['UserId'] = function($c){
		return \OCP\USER::getUser();
	};

	$newsContainer['Request'] = $newsContainer->share(function($c){
		return new Request($c['UserId'], $_GET, $_POST);
	});


	$newsContainer['Trans'] = function($c){
		return \OC_L10N::get($c['AppName']);
	};


	$newsContainer['Security'] = $newsContainer->share(function($c) {
		return new Security($c['AppName']);	
	});

	/** 
	 * MAPPERS
	 */
	$newsContainer['ItemMapper'] = $newsContainer->share(function($c){
		return new ItemMapper($c['UserId']);
	});

	$newsContainer['FeedMapper'] = $newsContainer->share(function($c){
		return new FeedMapper($c['UserId']);
	});

	$newsContainer['FolderMapper'] = $newsContainer->share(function($c){
		return new FolderMapper($c['UserId']);
	});


	/** 
	 * CONTROLLERS
	 */
	$newsContainer['NewsController'] = function($c){
		return new NewsController($c['Request'], $c['AppName'], $c['FeedMapper'], 
									$c['FolderMapper'], $c['Security']);
	};

	$newsContainer['NewsAjaxController'] = function($c){
		return new NewsAjaxController($c['Request'], $c['AppName'], $c['FeedMapper'], 
										$c['FolderMapper'], $c['ItemMapper'], 
										$c['Security'], $c['Trans']);
	};

	return $newsContainer;
}