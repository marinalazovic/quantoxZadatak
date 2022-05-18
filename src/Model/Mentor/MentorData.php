<?php

namespace PhpApi\Model\Mentor;

class MentorData extends MentorPayload
{
    public int $yearsOfExperience;
    public int $groupId;

    public function __construct(string $firstName, string $lastName, int $yearsOfExperience, int $groupId)
    {
        parent::__construct($firstName, $lastName);
        $this->yearsOfExperience= $yearsOfExperience;
        $this->groupId = $groupId;
    }

}