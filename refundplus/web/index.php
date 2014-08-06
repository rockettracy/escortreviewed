<?php

require_once __DIR__.'/../vendor/autoload.php';

function isDebugMode()
{
    return (bool)getenv('SEARCH_DEBUG');
}

// ---------------- only for php54 embedded web server to serve static files
if (isDebugMode()) {
    $filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }
}

$app = new Silex\Application();

require __DIR__.'/../resources/config/prod.php';
require __DIR__.'/../src/app.php';

require __DIR__.'/../src/controllers.php';

$app['http_cache']->run();
