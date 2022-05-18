<?php

namespace PhpApi\Model\Intern;

class InternData extends InternPayload
{
    public int $groupId;

    public function __construct(string $firstName, string $lastName, int $groupId)
    {
        parent::__construct($firstName, $lastName);
        $this->groupId=$groupId;
    }
}