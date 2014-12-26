<?php
namespace Editorial\Core\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure\Engine\PhpConfig;

class EditorialHelper extends Helper {

/**
 * Helpers used by Editorial Helper
 *
 * @var array
 */
	public $helpers = ['Html'];

/**
 * Default config for the helper.
 *
 * @var array
 */
	protected $_defaultConfig = [
		'options' => []
	];

	public function __construct(View $View, array $config = []) {
		if (isset($config['options'])) {
			if (is_string($config['options'])) {
				$this->loadConfig($config['options']);
				unset($config['options']);
			}
		}
		parent::__construct($View, $config);
	}

	public function initialize() {
		return $content;
	}

	public function connect($content = null) {
		return $content;
	}

	public function input(){
		return true;
	}

/**
 * Load a config file containing editor options.
 *
 * @param string $file The file to load
 * @return void
*/
	public function loadConfig($file) {
		$loader = new PhpConfig();
		$options = $loader->read($file);
		$this->config('options', $options);
	}
}
