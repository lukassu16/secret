<?php

namespace ShareApp\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class LoadSecretAction
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $identyfikator = $request->getAttribute('identyfikator');

        return $this->twig->render($response, '/secret/read_secret.twig', [
            'uuid' => $identyfikator
        ]);
    }
}