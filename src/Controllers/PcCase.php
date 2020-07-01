<?php


namespace App\Controllers;


use App\Services\API\JsonApi\PcCaseHandler;
use App\Services\API\JsonApi\Specification\PcCaseComposer;
use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PcCase
{
    public function get(Request $req, array $placeholders): Response
    {
        $cpuComposer = new PcCaseComposer(new PcCaseHandler(), $req->query, $placeholders['id']);
        $cpuComposer->assemble();

        return JsonResponse::success($cpuComposer->getResource());
    }
}