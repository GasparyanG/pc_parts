<?php


namespace App\Services\API\JsonApi\Specification;


use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response
{
    const CONTENT_TYPE = 'application/vnd.api+json';
    const CONTENT_TYPE_HEADER = 'Content-Type';

    public static function success(array $resource): HttpResponse
    {
        return HttpResponse::create(json_encode($resource), HttpResponse::HTTP_OK, [self::CONTENT_TYPE_HEADER => self::CONTENT_TYPE]);
    }
}