<?php

namespace Helpers; 

use Psr\Http\Message\ResponseInterface as Response;

class JsonResponse
{
    public static function withJson(array $json, int $code, Response $response)
    {
        $response->getBody()->write((string)json_encode($json));

        $response = $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus($code);

        return $response;
    }
}