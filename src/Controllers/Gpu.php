<?php


namespace App\Controllers;


use App\Services\API\JsonApi\GPUHandler;
use App\Services\API\JsonApi\Specification\GPUComposer;
use Symfony\Component\HttpFoundation\Request;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Gpu
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new GPUComposer(new GPUHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}