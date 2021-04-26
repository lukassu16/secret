<?php

namespace ShareApp\Action;

use ShareApp\Domain\Secret\Service\SecretCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SecretCreateAction
{
    private $secretCreator;

    public function __construct(SecretCreator $secretCreator)
    {
        $this->secretCreator = $secretCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        // Collect input from the HTTP request
        $data = (array) $request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $secretUuid = $this->secretCreator->createSecret($data);

        // Transform the result into the JSON representation
        $result = [
            'secretUrl' => 'http://localhost/api/v1/secret/'.$secretUuid,
        ];

        // Build the HTTP response
        $response->getBody()->write((string) json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
