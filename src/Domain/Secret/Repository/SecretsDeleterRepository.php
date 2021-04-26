<?php

namespace ShareApp\Domain\Secret\Repository;

use PDO;

/**
 * Repository.
 */
class SecretsDeleterRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function deleteSecrets()
    {
        $currentTime = date('Y-m-d H:i:s'); 
        $query = "DELETE FROM secrets
            WHERE data_wygasniecia <= '" .$currentTime. "'";

        $this->connection->query($query);
    }
}
