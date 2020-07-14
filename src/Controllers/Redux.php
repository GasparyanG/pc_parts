<?php


namespace App\Controllers;


use App\Services\TemplateEngine\Twig\Twig;
use Symfony\Component\HttpFoundation\Response;

class Redux
{
    public function get(): Response
    {
        return Response::create((new Twig())->render("redux_test.html.twig"));
    }
}