<?php

namespace PhpApi\Api;

use PhpApi\Db\Comment\CommentRepository;

class CommentController
{
    private CommentRepository $repository;

    public function __construct($connection)
    {
        $this->repository=new CommentRepository($connection);
    }

    public function exec($requestMethod, $mentorId, $internId,$commentId) {
        if($this->check( $mentorId, $internId)){
            switch ($requestMethod){
                case "POST":
                    $this->insertComment($mentorId, $internId);
                    break;
                case "DELETE":
                    $this->deteleComment($commentId,$mentorId);
                default:
                    $this->notFoundResponse();
            }
            
        } else {
            echo "Mentor sa id:".$mentorId." nije mentor praktikantu sa id:".$internId;
            $this->notFoundResponse(); 
        }
    }

    private function check($mentorId, $internId)
    {
        if($this->repository->approve($mentorId, $internId))
            return true;
        else
            return false;
    }

    private function notFoundResponse()
    {
        header("HTTP/1.1 404 Not Found");
    }

    private function insertComment($mentorId, $internId)
    {
        $body=json_decode(file_get_contents('php://input'),TRUE);
        $comment=$this->repository->insertGroup($body["text"],$mentorId, $internId);
        header("HTTP/1.1 200 OK");
        echo json_encode($comment);

    }

    private function deteleComment($commentId,$mentorId)
    {
        $this->repository->deleteComment($commentId,$mentorId);
        header("HTTP/1.1 200 OK");
    }
}