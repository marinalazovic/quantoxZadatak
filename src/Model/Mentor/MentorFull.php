<?php

namespace PhpApi\Model\Mentor;


use PhpApi\Model\Group\Group;
use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Mentor\Mentor;


class MentorFull extends Mentor
{
    public GroupPayload $grupa;

    public function __construct(int $id, string $firstName, string $lastName, int $yearsOfExperience,GroupPayload $grupa)
    {
        parent::__construct($id, $firstName, $lastName, $yearsOfExperience);
        $this->grupa=$grupa;
    }

}