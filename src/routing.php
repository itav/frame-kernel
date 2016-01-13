<?php
/**
 * Created by PhpStorm.
 * User: Magdalena
 * Date: 2016-01-13
 * Time: 11:37
 */
use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('hello', new Routing\Route('/hello/{year}', array(
    'year' => null,
    '_controller' => '\Itav\Invoice\Controller\InvoiceController::indexAction',
)));

$routes->add('bye', new Routing\Route('/bye', array(
    '_controller' => '\Itav\Invoice\Controller\InvoiceController::byeAction'
)));

return $routes;