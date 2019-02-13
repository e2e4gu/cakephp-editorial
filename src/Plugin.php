<?php
namespace Editorial\Core;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\EventManager;

class Plugin extends BasePlugin
{

    public function middleware($middleware)
    {
        $shortenAsset = new \Editorial\Core\Routing\Middleware\ShortenAssetMiddleware;
        $middleware->insertBefore(
            'Cake\Routing\Middleware\AssetMiddleware',
            $shortenAsset
        );
        return $middleware;
    }

    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);

        //App core event with widgets bulk load
        EventManager::instance()->on(
            new \Editorial\Core\Event\EditorialEvent,
            ['priority' => 10]
        );
    }

}
