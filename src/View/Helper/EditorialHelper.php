<?php
namespace Editorial\Core\View\Helper;

use Editorial\Core\Core\NamespaceTrait;
use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Utility\Inflector;

class EditorialHelper extends Helper {

	use NamespaceTrait;

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

	public function __construct(View $View, array $config = array()) {
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

	public function css($path, array $options = array()){
		$shortenUrls = Configure::read('Editorial.shortenUrls');
		if(Configure::read('Editorial.shortenUrls')){
			$path = $this->shortenize($path);
			$options['plugin'] = false;
		}
		return $this->Html->css($path, $options);
	}

	public function script($path, array $options = array()){
		$shortenUrls = Configure::read('Editorial.shortenUrls');
		if(Configure::read('Editorial.shortenUrls')){
			$path = $this->shortenize($path);
			$options['plugin'] = false;
		}
		return $this->Html->script($path, $options);
	}

	protected function shortenize($path){
		list($plugin, $path) = pluginSplit($path);
		if(!$plugin){
			return $path;
		}
		list($vendor, $class) = $this->vendorSplit($plugin);
		return Inflector::underscore($class).'/'.$path;
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
