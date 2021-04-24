<?php

namespace App\Domain\Secret\Service;

use App\Domain\Secret\Repository\SecretsDeleterRepository;

/**
 * Service.
 */
final class SecretsDeleter
{
    /**
     * @var SecretsDeleterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param SecretsDeleterRepository $repository The repository
     */
    public function __construct(SecretsDeleterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function deleteSecrets()
    {
        $this->repository->deleteSecrets();
    }
}
