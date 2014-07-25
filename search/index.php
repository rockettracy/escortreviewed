<?php
require_once __DIR__.'/vendor/autoload.php';
use Symfony\Component\Yaml\Parser;

// ---------------- only for php54 embedded web server to serve static files
if (getenv('SEARCH_DEBUG')) {
    $filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
        return false;
    }
}

$app = new Silex\Application();

// ------ register all services ----------
$parser = new Parser();
$config = $parser->parse(file_get_contents(__DIR__ . '/config/main.yml'));

foreach ($config['serviceprovider'] as $provider => $options) {
    $options = $options ?: array();
    $app->register(new $provider(), $options);
}

// ------------------- route -----------
$app->get('/', function() use($app) {
    return $app['twig']->render('index.twig', array(
        'name' => $app['hello']('aaaaa')
    ));
});
$app->get('/about', function() use($app) {
    return $app['twig']->render('about.twig', array(
        'name' => $app['hello']('aaaaa')
    ));
});
$app->get('/contactus', function() use($app) {
    return $app['twig']->render('contactus.twig', array(
        'name' => $app['hello']('aaaaa')
    ));
});




$app->run();
