<?php

namespace PhpApi\Api;

use PhpApi\Db\Intern\InternRepository;

class InternController {
    private InternRepository $repository;

    public function __construct($connection)
    {
        $this->repository=new InternRepository($connection);
    }

    public function exec($requestMethod, $id) {
        switch ($requestMethod){
            case"GET":
                if($id)
                    $this->getInternById($id);
                else
                    $this->getAllIntern();
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
    }

    private function getAllIntern()
    {
    }

    private function postInsertIntern()
    {
    }

    private function putUpdateIntern($id)
    {
    }

    private function deleteIntern($id)
    {
    }
    private function notFoundResponse()
    {
    }
}