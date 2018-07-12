<?php declare(strict_types = 1);

$injector = new \Auryn\Injector;

$injector->alias('Http\Request', 'Http\HttpRequest');
$injector->share('Http\HttpRequest');
$injector->define('Http\HttpRequest', [
    ':get' => $_GET,
    ':post' => $_POST,
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER
]);

$injector->alias('Http\Response', 'Http\HttpResponse');
$injector->share('Http\HttpResponse');

/**
 *  Tempalte Engines
 * 
 *      Mustache
 */


$injector->define('Mustache_Engine', [
    ':options' => [
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
            'extension' => '.html',
        ]),
    ]
]);

/**
 * Template Engines
 * 
 *      Twig Environment
 */

$injector->delegate('Twig_Environment', function () use ($injector) {
    $loader = new Twig_Loader_Filesystem(dirname(__DIR__) . '/templates');
    $twig = new Twig_Environment($loader);
    return $twig;
});


/**
 * Template Engines
 * 
 *      Chose which engine you would like to use.
 *          $injector->alias('Example\Template\Renderer', 'Example\Template\MustacheRenderer');
 *          $injector->alias('Example\Template\Renderer', 'Example\Template\TwigRenderer');
 */

$injector->alias('Example\Template\Renderer', 'Example\Template\TwigRenderer');


$injector->alias('Example\Template\FrontendRenderer', 'Example\Template\FrontendTwigRenderer');
$injector->alias('Example\Template\ParsedownRenderer', 'Example\Template\MarkdownRenderer');

$injector->define('Example\Page\FilePageReader', [
    ':pageFolder' => __DIR__ . '/pages/hello/',
]);
$injector->alias('Example\Page\PageReader', 'Example\Page\FilePageReader');
$injector->share('Example\Page\FilePageReader');

$injector->define('Example\Blog\BlogPageReader', [
    ':pageFolder' => __DIR__ . '/pages/blog/',
]);
$injector->alias('Example\Blog\BlogReader', 'Example\Blog\BlogPageReader');
$injector->share('Example\Blog\BlogPageReader');

$injector->alias('Example\Menu\MenuReader', 'Example\Menu\ArrayMenuReader');
$injector->share('Example\Menu\ArrayMenuReader');

return $injector;