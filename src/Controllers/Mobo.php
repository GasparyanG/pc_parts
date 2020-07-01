<?php


namespace App\Controllers;


use App\Services\API\JsonApi\MoboHandler;
use App\Services\API\JsonApi\Specification\MoboComposer;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Mobo
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new MoboComposer(new MoboHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}