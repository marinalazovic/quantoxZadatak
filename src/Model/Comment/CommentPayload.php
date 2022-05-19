<?php

namespace  PhpApi\Model\Comment;

class CommentPayload
{
   public string $text;
   public string $date;
   public int $mentorId;
   public int $internId;

   public function __construct(string $text, string $date, int $mentorId, int $internId)
   {
       $this->text=$text;
       $this->date=$date;
       $this->mentorId=$mentorId;
       $this->internId=$internId;
   }

}