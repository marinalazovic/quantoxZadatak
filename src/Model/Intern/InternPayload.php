<?php

namespace  PhpApi\Model\Intern;

class InternPayload {
    public string $firstName;
    public string $lastName;


    public function __construct(string $firstName,string $lastName)
    {
        $this->firstName=$firstName;
        $this->lastName=$lastName;

    }
}