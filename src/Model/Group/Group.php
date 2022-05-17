<?php

namespace PhpApi\Model\Group;


class Group extends GroupPayload {
    public int $id;

    public function __construct(int $id, string $groupName)
    {
        parent::__construct($groupName);
        $this->id=$id;
    }
}
