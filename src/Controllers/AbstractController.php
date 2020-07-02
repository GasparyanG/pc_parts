<?php


namespace App\Controllers;


use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    /**
     * @var string|null
     */
    protected static $composer = null;

    /**
     * @var string|null
     */
    protected  static $handler = null;

    public function get(Request $req, array $placeholders): Response
    {
        $composer = new static::$composer(new static::$handler(), $req->query, $placeholders['id']);
        $composer->assemble();

        return JsonResponse::success($composer->getResource());
    }

    public function getCollection(Request $req, array $placeholders): Response
    {
        $composer = new static::$composer(new static::$handler(), $req->query);
        $composer->assembleCollection();

        return JsonResponse::success($composer->getResource());
    }
}