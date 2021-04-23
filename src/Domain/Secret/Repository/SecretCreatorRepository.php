<?php

namespace App\Domain\Secret\Repository;

use ParagonIE\Halite\Primitive\Symmetric;
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
        // $encryption_key = EncryptionKey::generate();
        // $ciphertext = Symmetric::encrypt($secret['secret'], $secret['key']);

        // $expirationTime = date('Y-m-d H:i:s')
        //strtotime('+1 hour +20 minutes',strtotime($start))

        $expirationTime = [
            'once' => null,
            '1H' => date('Y-m-d H:i:s', strtotime('+1 hour', strtotime(date('Y-m-d H:i:s')))),
            '24H' => date('Y-m-d H:i:s', strtotime('+1 day', strtotime(date('Y-m-d H:i:s')))),
            '7D' => date('Y-m-d H:i:s', strtotime('+7 day', strtotime(date('Y-m-d H:i:s')))),
            '10M' => date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime(date('Y-m-d H:i:s')))),
        ][$secret['type']];

        $row = [
            'uuid' => Uuid::uuid4(),
            'sekret' => $secret['secret'],
            'kod' => $secret['key'],
            'typ' => $secret['type'],
            'data_wygasniecia' => $expirationTime,
        ];

        $sql = 'INSERT INTO secrets SET
                uuid=:uuid,
                sekret=:sekret,
                kod=:kod,
                typ=:typ,
                data_wygasniecia=:data_wygasniecia;';

        $this->connection->prepare($sql)->execute($row);

        // return (string) $this->connection->lastInsertId('uuid');
        return $row['uuid'];
    }
}
