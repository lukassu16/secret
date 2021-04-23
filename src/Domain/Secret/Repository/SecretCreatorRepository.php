<?php

namespace App\Domain\Secret\Repository;

use PDO;
use Ramsey\Uuid\Uuid;



/**
 * Repository.
 */
class SecretCreatorRepository
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

    /**
     * Insert secret row.
     *
     * @param array $secret The secret
     *
     * @return int The new ID
     */
    // public function insertSecret(array $secret): string
    public function insertSecret(array $secret)
    {
        $row = [
            'uuid' => Uuid::uuid4(),
            'sekret' => $secret['secret'],
            'kod' => $secret['key'],
            'typ' => $secret['type'],
            'data_wygasniecia' => date("Y/m/d"),
        ];

        $sql = 'INSERT INTO secrets SET
                uuid=:uuid,
                sekret=:sekret,
                kod=:kod,
                typ=:typ,
                data_wygasniecia=:data_wygasniecia;';

        $cosiek = $this->connection->prepare($sql)->execute($row);

        // return (string) $this->connection->lastInsertId('uuid');
        return $row['uuid'];
    }
}
