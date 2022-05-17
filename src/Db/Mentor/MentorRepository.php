<?php

namespace PhpApi\Db\Mentor;

class MentorRepository {
    private PDO $connection;

    public function __construct($connection)
    {
        $this->connection=$connection;
    }
}