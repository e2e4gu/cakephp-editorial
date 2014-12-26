<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) iTeam s.r.o. (http://iteam-pro.com)
* @link          http://iteam-pro.com Garderobe CakePHP 3 UI Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/
namespace Editorial\Core\Event;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class EditorialEvent implements EventListenerInterface {

	public function implementedEvents() {
		return array(
			//'View.afterRenderFile' => array(
			'View.beforeLayout' => array(
				'callable' => 'injectEditor',
			),
		);
	}

	public function injectEditor(Event $event, $layoutFile){
		$_view = $event->subject();
		$content = $_view->fetch('content');
		if(Configure::read('Editorial.autoload')){
			$searchClass = Configure::read('Editorial.autoload');
			if(empty($searchClass)){
				$searchClass = 'editor';
			}
			$editorClassName = Configure::read('Editorial.editor');
			$searchRegex = '/(<textarea.*class\=\".*'
				.Configure::read('Editorial.class').'\"[^>]*>.*<\/textarea>)/isU';
			if(($editorClassName !== false)&&preg_match_all($searchRegex, $content, $matches)){
				if(!$_view->helpers()->has('Editor')) {
					$options['className'] = 'Editorial/'.$editorClassName.'.'.$editorClassName;
					if($editorDefaults = Configure::read('Editorial.'.$editorClassName.'.defaults')) {
						$options['options'] = $editorDefaults;
					}
					$_view->loadHelper('Editor', $options);
					$_view->Editor->initialize();
				}
				$_view->Editor->connect($content);
			}
		}
	}
}
