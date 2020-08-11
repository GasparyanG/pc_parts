<?php


namespace App\Controllers;


use App\Services\TemplateEngine\Twig\Twig;
use Symfony\Component\HttpFoundation\Response;

class Home
{
    public function get(): Response
    {
        $twig = new Twig();
        return Response::create($twig->render("home.html.twig",  ["title" => "Home"]));
    }
}