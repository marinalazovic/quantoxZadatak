<?php

namespace PhpApi\Api;


use PhpApi\Db\Mentor\MentorRepository;
use PhpApi\Model\Mentor\MentorData;
use PhpApi\Model\Mentor\MentorDataId;

class MentorController
{
   private MentorRepository $repository;

   public function __construct($conncection)
   {
       $this->repository = new MentorRepository($conncection);
   }

   public function exec($requestMethod, $id,$sort,$order,$limit, $page) {
       switch ($requestMethod) {
           case "GET":
               if($id)
                   $this->getMentorById($id);
               else
                   $this->getAllMentors($sort,$order,$limit, $page);
               break;
           case "POST":
                   $this->postCreate();
               break;
           case "PUT":
                   $this->putUpdate($id);
               break;
           case "DELETE":
                    $this->delete($id);
               break;
           default:
               $this->notFounResponse();
       }
   }

    private function getMentorById($id)
    {
        $mentor = $this->repository->getMentorById($id);
        header("HTTP:1.1 200 OK");
        echo json_encode($mentor);
    }

    private function getAllMentors($sort,$order,$limit, $page)
    {
        if($sort !== null && $order !== null)
             $mentors = $this->repository->getAllMentors($sort,$order,$limit, $page);
        else
            $mentors = $this->repository->getAllMentors($limit, $page);
        header("HTTP:1.1 200 OK");
        echo json_encode($mentors);
    }

    private function postCreate()
    {
        $body =json_decode(file_get_contents('php://input'), TRUE);
        $mentor= $this->repository->insert(new MentorData(
            $body["first_name"],
            $body["last_name"],
            $body["years_of_experience"],
            $body["group_id"]
        ));
        header("HTTP/1.1 200 OK");
        echo json_encode($mentor);
    }

    private function putUpdate($id)
    {
        $body = json_decode(file_get_contents('php://input'),TRUE);
        $mentor= $this->repository->update(new MentorDataId(
            $id,
            $body["first_name"],
            $body["last_name"],
            $body["years_of_experience"],
            $body["group_id"]
        ));
        header("HTTP/1.1 200 OK");
        echo json_encode($mentor); die;
    }

    private function delete($id)
    {
        $this->repository->delete($id);
        header("HTTP/1.1 200 OK");
    }

    private function notFounResponse()
    {
        header("HTTP/1.1 404 Not Found");
    }
}