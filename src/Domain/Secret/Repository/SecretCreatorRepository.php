<?php

namespace ShareApp\Domain\Secret\Repository;

use ParagonIE\Halite\Symmetric\Crypto as Symmetric;
use PDO;
use Ramsey\Uuid\Uuid;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\Halite\HiddenString;

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
        $key = new HiddenString($secret['key']);

        $salt = "\xdd\x7b\x1e\x38\x75\x9f\x72\x86\x0a\xe9\xc8\x58\xf6\x16\x0d\x3b";

        $encryptionKey = KeyFactory::deriveEncryptionKey($key, $salt);

        $message = new HiddenString($secret['secret']);
        $ciphertext = Symmetric::encrypt($message, $encryptionKey);

        $expirationTime = [
            'once' => null,
            '1H' => date('Y-m-d H:i:s', strtotime('+1 hour', strtotime(date('Y-m-d H:i:s')))),
            '24H' => date('Y-m-d H:i:s', strtotime('+1 day', strtotime(date('Y-m-d H:i:s')))),
            '7D' => date('Y-m-d H:i:s', strtotime('+7 day', strtotime(date('Y-m-d H:i:s')))),
            '10M' => date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime(date('Y-m-d H:i:s')))),
        ][$secret['type']];

        $row = [
            'uuid' => Uuid::uuid4(),
            'sekret' => $ciphertext,
            'klucz' => $secret['key'],
            'typ' => $secret['type'],
            'data_wygasniecia' => $expirationTime,
        ];

        $sql = 'INSERT INTO secrets SET
                uuid=:uuid,
                sekret=:sekret,
                klucz=:klucz,
                typ=:typ,
                data_wygasniecia=:data_wygasniecia;';

        $this->connection->prepare($sql)->execute($row);

        return $row['uuid'];
    }
}
