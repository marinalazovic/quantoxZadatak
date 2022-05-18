<?php

namespace PhpApi\Model\Mentor;

class MentorDataId extends MentorData
{
    public int $id;

    public function __construct(int $id, string $firstName, string $lastName, int $yearsOfExperience, int $groupId)
    {
        parent::__construct($firstName, $lastName, $yearsOfExperience, $groupId);
        $this->id = $id;

    }
}