<?php

namespace ShareApp\Domain\Secret\Service;

use ShareApp\Domain\Secret\Repository\SecretCreatorRepository;
use ShareApp\Exception\ValidationException;

/**
 * Service.
 */
final class SecretCreator
{
    /**
     * @var SecretCreatorRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param SecretCreatorRepository $repository The repository
     */
    public function __construct(SecretCreatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new secret.
     *
     * @param array $data The form data
     *
     * @return int The new secret ID
     */
    public function createSecret(array $data)
    {
        // Input validation
        $this->validateNewSecret($data);

        // Insert secret
        $secretUuid = $this->repository->insertSecret($data);

        // Logging here: Secret created successfully
        //$this->logger->info(sprintf('Secret created successfully: %s', $secretUuid));

        return $secretUuid;
    }

    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewSecret(array $data): void
    {
        $errors = [];

        if (empty($data['secret'])) {
            $errors['secret'] = 'Input required';
        }

        if (empty($data['key'])) {
            $errors['key'] = 'Input required';
        } 

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
