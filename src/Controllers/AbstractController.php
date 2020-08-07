<?php


namespace App\Controllers;


use App\Services\API\JsonApi\Specification\Response as JsonResponse;
use App\Services\TemplateEngine\Twig\Twig;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{
    const API = "api";

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
        // response with api or not
        $api = $req->query->get(self::API);
        if ((bool)$api !== true) {
            return Response::create((new Twig())->render("collection_of_part.html.twig", ["not_home" => true]));
        } else {
            $composer = new static::$composer(new static::$handler(), $req->query);
            $composer->assembleCollection();

            return JsonResponse::success($composer->getResource());
        }
    }
}