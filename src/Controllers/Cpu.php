<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Cpu
{
    public function get(Request $req, array $placeholders): Response
    {
        return Response::create(json_encode($placeholders));
    }
}