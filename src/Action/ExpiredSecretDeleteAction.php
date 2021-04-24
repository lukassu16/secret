<?php

namespace App\Action;

use App\Domain\Secret\Service\SecretsDeleter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExpiredSecretDeleteAction
{
    private $secretsDeleter;

    public function __construct(SecretsDeleter $secretsDeleter)
    {
        $this->secretsDeleter = $secretsDeleter;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $this->secretsDeleter->deleteSecrets();

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
