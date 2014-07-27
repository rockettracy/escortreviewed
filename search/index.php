<?php
require_once __DIR__.'/vendor/autoload.php';
use Symfony\Component\Yaml\Parser;

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

// ------ register all services ----------
$parser = new Parser();
$config = $parser->parse(file_get_contents(__DIR__ . '/config/main.yml'));
if (isDebugMode()) {
    $config['serviceprovider']['Silex\Provider\TwigServiceProvider']['twig.path'] = '/Users/kelinliu/work/dev/out/projects/escortreviewed/search/views';
}

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
$app->get('/privacy', function() use($app) {
    return $app['twig']->render('privacy.twig', array(
        'name' => $app['hello']('aaaaa')
    ));
});




$app->run();
