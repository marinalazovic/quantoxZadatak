<?php

namespace PhpApi\Model\Intern;

class Intern extends InternPayload
{
    public int $id;

    public function __construct(int $id, string $firstName, string $lastName)
    {
        parent::__construct($firstName, $lastName);
        $this->id = $id;
    }
}