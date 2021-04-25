<?php

namespace App\Domain\Secret\Service;

use App\Domain\Secret\Repository\SecretReaderRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class SecretReader
{
    /**
     * @var SecretReaderRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param SecretReaderRepository $repository The repository
     */
    public function __construct(SecretReaderRepository $repository)
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
    public function getSecret(array $data)
    {
        // Input validation
        // $this->validateSecret($data);

        // Insert secret
        $secret = $this->repository->getSecret($data);

        // Logging here: Secret created successfully
        //$this->logger->info(sprintf('Secret created successfully: %s', $secretUuid));

        return $secret;
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
    private function validateSecret(array $data): void
    {
        // $errors = [];

        // if (empty($data['secret'])) {
        //     $errors['secret'] = 'Input required';
        // }

        // if (empty($data['key'])) {
        //     $errors['key'] = 'Input required';
        // }

        // if ($errors) {
        //     throw new ValidationException('Please check your input', $errors);
        // }
    }
}
