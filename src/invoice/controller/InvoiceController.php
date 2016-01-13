<?php

/**
 * Created by PhpStorm.
 * User: Magdalena
 * Date: 2016-01-13
 * Time: 14:04
 */
namespace Itav\Invoice\Controller;

use Symfony\Component\HttpFoundation\Response;

class InvoiceController
{
    public function indexAction($year)
    {
        if ($year%2 === 0 ) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }

    public function byeAction()
    {
        return new Response("Goodbye!");
    }

}