<?php

namespace App\Domain\Secret\Repository;

use PDO;
use ParagonIE\Halite\KeyFactory;
use ParagonIE\Halite\HiddenString;
use ParagonIE\Halite\Symmetric\Crypto as Symmetric;
use ParagonIE\Halite\Symmetric\EncryptionKey;

/**
 * Repository.
 */
class SecretReaderRepository
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
    public function getSecret(array $secret)
    {
        $uuid = $secret['identyfikator'];

        $sql = 'SELECT * FROM secrets WHERE
            uuid = "'.$uuid.'"';

        $statement = $this->connection->query($sql);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // odszyfrowanie 

        $key = new HiddenString($row['klucz']);

        $salt = "\xdd\x7b\x1e\x38\x75\x9f\x72\x86\x0a\xe9\xc8\x58\xf6\x16\x0d\x3b";

        $encryptionKey = KeyFactory::deriveEncryptionKey($key, $salt);

        $message = new HiddenString($row['sekret']);

        $decrypted = Symmetric::decrypt($message, $encryptionKey);

        $row['sekret'] = $decrypted->getString();
        return $row;
    }
}
