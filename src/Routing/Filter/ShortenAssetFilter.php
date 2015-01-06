<?php
namespace Editorial\Core\Routing\Filter;

use Cake\Routing\Filter\AssetFilter;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Utility\Inflector;

/**
 * Filters a request and tests whether it is a file in the webroot folder or not and
 * serves the file to the client if appropriate.
 *
 */
class ShortenAssetFilter extends AssetFilter {

/**
 * Default priority for all methods in this filter
 * This filter should run before the request gets parsed by router
 *
 * @var int
 */
	protected $_priority = 9;

/**
 * Builds asset file path based off url
 *
 * @param string $url Asset URL
 * @return string Absolute path for asset file
 */
	protected function _getAssetFile($url) {
		$parts = explode('/', $url);
		$asset = array_shift($parts);
		$parts[0] = $asset;
		$path = Plugin::path(Configure::read('Editorial.editor')). Configure::read('App.webroot'). DS . implode(DS, $parts);
		if (file_exists($path)) {
			return $path;
		}
	}

}
