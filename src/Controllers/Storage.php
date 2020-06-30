<?php


namespace App\Controllers;

use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use App\Services\API\JsonApi\Specification\StorageComposer;
use App\Services\API\JsonApi\StorageHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Storage
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new StorageComposer(new StorageHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}