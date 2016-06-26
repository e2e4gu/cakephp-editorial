<?php
use Cake\Routing\Router;

Router::plugin('Editorial/Core', function ($routes) {
    $routes->fallbacks();
});
