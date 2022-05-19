<?php

namespace PhpApi\Api;

use PhpApi\Db\Intern\InternRepository;
use PhpApi\Model\Intern\InternData;
use PhpApi\Model\Intern\InternDataId;

class InternController {
    private InternRepository $repository;

    public function __construct($connection)
    {
        $this->repository=new InternRepository($connection);
    }

    public function exec($requestMethod, $id,$sort,$order,$limit, $page) {
        switch ($requestMethod){
            case"GET":
                if($id)
                    $this->getInternById($id);
                else
                    $this->getAllIntern($sort,$order,$limit, $page);
                break;
            case"POST":
                $this->postInsertIntern();
                break;
            case"PUT":
                $this->putUpdateIntern($id);
                break;
            case"DELETE":
                $this->deleteIntern($id);
                break;
            default:
                $this->notFoundResponse();
        }
    }



    private function getInternById($id)
    {
        $intern = $this->repository->getInternById($id);
        header("HTTP/1.1 200 OK");
        echo json_encode($intern);
    }

    private function getAllIntern($sort,$order,$limit, $page)
    {
        if($sort !== null && $order !== null)
            $interns= $this->repository->getAllIntern($limit, $page,$sort,$order);
        else
            $interns= $this->repository->getAllIntern($limit, $page);

        header("HTTP/1.1 200 OK");
        echo json_encode($interns);
    }

    private function postInsertIntern()
    {
        $body = json_decode(file_get_contents('php://input'), TRUE);
        $intern = $this->repository->insert(new InternData(
            $body["first_name"],
            $body["last_name"],
            $body["group_id"]
        ));

        header("HTTP/1.1 200 OK");
        echo json_encode($intern);
    }

    private function putUpdateIntern($id)
    {
        $body = json_decode(file_get_contents('php://input'), TRUE);

        $intern = $this->repository->update(new InternDataId(
            $id,
            $body["first_name"],
            $body["last_name"],
            $body["group_id"]
        ));
        header("HTTP/1.1 200 OK");
        echo json_encode($intern);
    }

    private function deleteIntern($id)
    {
        $this->repository->delete($id);
        header("HTTP/1.1 200 OK");
    }
    private function notFoundResponse()
    {
        header("HTTP/1.1 404 Not Found");
    }
}