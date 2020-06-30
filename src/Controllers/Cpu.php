<?php


namespace App\Controllers;


use App\Services\API\JsonApi\CPUHandler;
use App\Services\API\JsonApi\Specification\CPUComposer;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Cpu
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new CPUComposer(new CPUHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}