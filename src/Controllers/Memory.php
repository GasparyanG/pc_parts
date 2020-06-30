<?php


namespace App\Controllers;


use App\Services\API\JsonApi\MemoryHandler;
use App\Services\API\JsonApi\Specification\MemoryComposer;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Memory
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new MemoryComposer(new MemoryHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}