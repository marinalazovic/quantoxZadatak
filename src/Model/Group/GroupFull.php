<?php

namespace PhpApi\Model\Group;


use PhpApi\Model\Intern\InternPayload;
use PhpApi\Model\Mentor\MentorPayload;

class GroupFull extends Group {
    public $mentori;
    public $praktikanti;

    public function __construct(int $id, string $groupName,$mentori, $praktikanti)
    {
        parent::__construct($id, $groupName);
        $this->mentori=$mentori;
        $this->praktikanti=$praktikanti;
    }
}