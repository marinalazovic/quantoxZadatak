<?php

namespace PhpApi\Model\Intern;

use PhpApi\Model\Comment\CommentPayload;

class InternComment extends InternDataId {
    public CommentPayload $comments;

    public function __construct(int $id, string $firstName, string $lastName, int $groupId, $comments)
    {
        parent::__construct($id, $firstName, $lastName, $groupId);
        $this->comments=$comments;
    }
}