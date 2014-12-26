<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) iTeam s.r.o. (http://iteam-pro.com)
* @link          http://iteam-pro.com Editorial Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/

use Cake\Core\Configure;
use Cake\Event\EventManager;

EventManager::instance()->attach(
	new Editorial\Core\Event\EditorialEvent,
	null
);

Configure::write('Editorial', [
	'editor' => false,
	'class' => 'editor',
	'autoload' => false
]);
