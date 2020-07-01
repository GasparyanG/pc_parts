<?php


namespace App\Controllers;


use App\Services\API\JsonApi\CoolerHandler;
use App\Services\API\JsonApi\Specification\CoolerComposer;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Cooler
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new CoolerComposer(new CoolerHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}