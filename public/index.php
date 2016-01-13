<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;

function render_template(Request $request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    return new Response(ob_get_clean());
}

$request = Request::createFromGlobals();
$requestStack = new \Symfony\Component\HttpFoundation\RequestStack();
$requestStack->push($request);
$routes = include __DIR__.'/../src/routing.php';

$context = new Routing\RequestContext();
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();


$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher, $requestStack));
$errorHandler = function (\Symfony\Component\Debug\Exception\FlattenException $exception) {
    $msg = 'Something went wrong! ('.$exception->getMessage().')';

    return new Response($msg, $exception->getStatusCode());
};
$listener = new HttpKernel\EventListener\ExceptionListener(
    'Itav\\Invoice\\Controller\\ErrorController::exceptionAction'
);

$dispatcher->addSubscriber($listener);
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));
$dispatcher->addSubscriber(new Itav\StringResponseListener());
$dispatcher->addSubscriber(new Itav\ContentLengthListener());

$framework = new Itav\FrameKernel($dispatcher, $resolver);

$response = $framework->handle($request);
$response->send();