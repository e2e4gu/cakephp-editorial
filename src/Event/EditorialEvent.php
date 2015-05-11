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

use Editorial\Core\Core\NamespaceTrait;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class EditorialEvent implements EventListenerInterface {

	use NamespaceTrait;

	public function implementedEvents() {
		return array(
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
			$plugin = Configure::read('Editorial.editor');
			list($vendor, $class) = $this->vendorSplit($plugin);
			$searchRegex = '/(<textarea.*class\=\".*'
				.Configure::read('Editorial.class').'.*\"[^>]*>.*<\/textarea>)/isU';
            //preg_match_all($searchRegex, $content, $matches);
            //debug($matches);
			if((Plugin::loaded($plugin) !== false)&&preg_match_all($searchRegex, $content, $matches)){
				if(!$_view->helpers()->has('Editor')) {
					$options['className'] = $class.'.'.$class;
					if($vendor){
						$options['className'] = $vendor.'/'.$options['className'];
					}
                    $options['options'] = $plugin.'.defaults';
					if($editorDefaults = Configure::read('Editorial.'.$class.'.defaults')) {
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
