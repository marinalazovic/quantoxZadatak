<?php

namespace PhpApi\Model\Mentor;

class Mentor extends MentorPayload {
    public int $id;
    public int $yearsOfExperience;

    public function __construct(int $id, string $firstName, string $lastName, int $yearsOfExperience)
    {
        parent::__construct($firstName, $lastName);
        $this->id=$id;
        $this->yearsOfExperience=$yearsOfExperience;
    }
}