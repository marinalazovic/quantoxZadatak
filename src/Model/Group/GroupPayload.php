<?php

namespace  PhpApi\Model\Group;



class GroupPayload {
    public string $groupName;


    public function __construct(string $groupName)
    {
        $this->groupName=$groupName;

    }
}