<?php

namespace PhpApi\Api;

use PhpApi\Db\Group\GroupRepository;
use PhpApi\Model\Group\Group;
use PhpApi\Model\Group\GroupFull;
use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Intern\InternPayload;
use PhpApi\Model\Mentor\MentorPayload;

class GroupController {
    private GroupRepository $repository;

    public function __construct($connection)
    {
        $this->repository= new GroupRepository($connection);
    }

    public function exec($requestMethod, $id,$sort,$order, $limit, $page) {
        switch ($requestMethod){
            case "GET":
                if($id)
                    $this->getGroupById($id);
                else
                    $this->getAllGroup($sort,$order,$limit, $page);

                break;
            case "POST":
                $this->postInsertGroup();
                break;
            case "PUT":
                $this->putUpdateGroup($id);
                break;
            case "DELETE":
                $this->deleteGroup($id);
                break;
            default:
                $this->notFoundResponse();
        }
    }
    private function getAllGroup($sort,$order, $limit, $page)
    {
        if($sort !== null && $order !== null)
            $allGroup=$this->repository->getAllGroup($limit, $page,$sort,$order);
        else
            $allGroup=$this->repository->getAllGroup($limit, $page);

        header("HTTP/1.1 200 OK");
        echo json_encode($allGroup);
    }

    public function getGroupById($id)
    {
        $groupFull= $this->repository->getGroupById($id);


        header("HTTP/1.1 200 OK");
        echo json_encode($groupFull);
    }

    private function postInsertGroup()
    {
        $body=json_decode(file_get_contents('php://input'),TRUE);

        $group = $this->repository->insertGroup(new GroupPayload(
           $body["group_name"]
        ));

        header("HTTP/1.1 200 OK");
        echo json_encode($group);
    }

    private function putUpdateGroup($id)
    {
        $body=json_decode(file_get_contents('php://input'),TRUE);

        $group=$this->repository->updateGroup(new Group(
            $id,
            $body["group_name"]
        ));
        header("HTTP/1.1 200 OK");
        echo json_encode($group);
    }

    private function deleteGroup($id)
    {
        $this->repository->deleteGroup($id);
        header("HTTP/1.1 200 OK");
    }

    private function notFoundResponse()
    {
        header("HTTP/1.1 404 Not Found");
    }
}