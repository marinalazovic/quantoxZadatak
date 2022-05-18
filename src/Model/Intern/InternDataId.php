<?php

namespace PhpApi\Model\Intern;

class InternDataId extends InternData
{
    public int $id;

    public function __construct(int $id, string $firstName, string $lastName, int $groupId)
    {
        parent::__construct($firstName, $lastName, $groupId);
        $this->id=$id;
    }

}