<?php
namespace Editorial\Core\View\Helper;

use Editorial\Core\Core\NamespaceTrait;
use Cake\View\Helper;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Utility\Inflector;
use Cake\Log\Log;

class EditorialHelper extends Helper {

	use NamespaceTrait;

/**
 * Helpers used by Editorial Helper
 *
 * @var array
 */
	public $helpers = ['Html', 'Form'];

/**
 * Default config for the helper.
 *
 * @var array
 */
	protected $_defaultConfig = [
        'block' => true,
        'options' => []
	];

	public function __construct(View $View, array $config = array())
    {
		if (isset($config['options'])) {
			if (is_string($config['options'])) {
				$this->loadConfig($config['options']);
				unset($config['options']);
			}
		}
		parent::__construct($View, $config);
	}

	public function initialize(array $config = array())
    {
		return $this->assets(true);
	}

    public function input($fieldName, array $options = [])
    {
        $block = $this->config('options.theme');
        if(isset($options['block'])){
            $block = $options['block'];
        }
        if(isset($this->_View->Form)){
            $input = $this->_View->Form->input($fieldName, $options);
        } else {
            $input = $this->Form->input($fieldName, $options);
        }
        $input .= $this->assets($block);
        $input .= $this->connect($input, $block);
		return $input;
	}

    public function assets($block = true)
    {
		return;
	}

	public function connect($content = null, $block = true)
    {
		return $content;
	}

	public function css($path, array $options = array())
    {
		$shortenUrls = Configure::read('Editorial.shortenUrls');
		if(Configure::read('Editorial.shortenUrls')
			&&(!isset($options['plugin'])||($options['plugin'] !== false))){
			$path = $this->shortenize($path);
			$options['plugin'] = false;
		}
		return $this->Html->css($path, $options);
	}

	public function script($path, array $options = array())
    {
		$shortenUrls = Configure::read('Editorial.shortenUrls');
		if(Configure::read('Editorial.shortenUrls')
			&&(!isset($options['plugin'])||($options['plugin'] !== false))){
			$path = $this->shortenize($path);
			$options['plugin'] = false;
		}
		return $this->Html->script($path, $options);
	}

	protected function shortenize($path)
    {
		if(!is_array($path)){
			$path = [$path];
		}
		foreach($path as $key=>$_path){
			list($plugin, $_path) = pluginSplit($_path);
			//Maybe not needed anymore
			//if(!$plugin){
			//	return $_path;
			//}
			list($vendor, $class) = $this->vendorSplit($plugin);
			$path[$key] = Inflector::underscore($class).'/'.$_path;
		}
		if(count($path) == 1){
			$path = $path[0];
		}
		return $path;
	}

    /**
     * Load a config file containing editor options.
     *
     * @param string $file The file to load
     * @return void
    */
	public function loadConfig($file)
    {
        $options = [];
        try {
            $loader = new PhpConfig();
            $options = $loader->read($file);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
        }
		$this->config('options', $options);
	}
}
