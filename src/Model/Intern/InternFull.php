<?php

namespace PhpApi\Model\Intern;


use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Intern\Intern;
use PhpApi\Model\Group\Group;
class InternFull extends Intern {
    public GroupPayload $grupa;

    public function __construct(int $id, string $firstName, string $lastName, Group $grupa)
    {
        parent::__construct($id, $firstName, $lastName);
        $this->grupa=$grupa;
    }
}