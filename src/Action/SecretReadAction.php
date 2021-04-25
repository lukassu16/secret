<?php

namespace App\Action;

use App\Domain\Secret\Service\SecretReader;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SecretReadAction
{
    private $secretReader;

    public function __construct(SecretReader $secretReader)
    {
        $this->secretReader = $secretReader;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $identyfikator = $request->getAttribute('identyfikator');

        $data = (array) $request->getParsedBody();

        $data['identyfikator'] = $identyfikator;

        $secret = $this->secretReader->getSecret($data);
        
        // Build the HTTP response
        $response->getBody()->write((string) json_encode($secret));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
