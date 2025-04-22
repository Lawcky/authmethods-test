<?php
use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require dirname(__DIR__).'/vendor/autoload.php';
(new Dotenv\Dotenv(dirname(__DIR__)))->usePutenv()->loadEnv('.env.local');

if ($_SERVER['APP_DEBUG'] ?? ('prod' !== ($_ENV['APP_ENV'] ?? 'dev'))) {
    umask(0000);
    Debug::enable();
}

$kernel = new Kernel($_SERVER['APP_ENV'] ?? 'dev', (bool) ($_SERVER['APP_DEBUG'] ?? true));
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

