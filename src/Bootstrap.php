<?php declare(strict_types = 1);

namespace Example;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
/**
 * Define the working environment.
 * 
 * Possible values: development | production | testing
 */
$environment = 'development';

/**
 * Register the Error handling.
 * 
 * If the environment is set to development, show
 *  advanced error reporting to assist with the
 *  debugging process.
 */

 $whoops = new \Whoops\Run;

if ($environment !== 'production'){
     $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e){
        echo "Todo: 500 Friendly error page and send email to developer or log file.";
    });
}

$whoops->register();

/**
 * Define the incoming Requests and outgoing Responses.
 */

 /**
 * Resolve the dependancies of the Classes and make sure that the correct
 * objects are injected when the class is instantiated.
 */
$injector = include('Dependencies.php');

$request = $injector->make('Http\HttpRequest');
$response = $injector->make('Http\HttpResponse');

/**
 * Defines the available routes a user can browse.
 * 
 * Adds each route to the RouteCollector. 
 */
$routeDefinitionCallback = function(\FastRoute\RouteCollector $r){
    $routes = include('Routes.php');

    foreach ($routes as $route){
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

/**
 * Determine what the user is requesting and determine the status code
 * for each request. * 
 */

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];
        
        $class = $injector->make($className);
        $class->$method($vars);
        break;
}

/**
 * Send the headers to the browser from the server.
 */
foreach ($response->getHeaders() as $header) {
    header($header, false);
}

/**
 * Send the content to the browser.
 */
echo $response->getContent();