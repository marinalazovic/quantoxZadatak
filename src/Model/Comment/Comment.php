<?php

namespace PhpApi\Model\Comment;

class Comment extends CommentPayload
{
    public int $id;

    public function __construct(int $id, string $text, string $date, int $mentorId, int $internId)
    {
        parent::__construct($text, $date, $mentorId, $internId);
        $this->id=$id;
    }
}