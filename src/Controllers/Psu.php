<?php


namespace App\Controllers;


use App\Services\API\JsonApi\PSUHandler;
use App\Services\API\JsonApi\Specification\PSUComposer;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Psu
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new PSUComposer(new PSUHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}