<?php

namespace PhpApi\Db\Intern;

use \PDO;
use \PDOException;
use PhpApi\Model\Group\Group;
use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Intern\Intern;
use PhpApi\Model\Intern\InternFull;
use PhpApi\Model\Intern\InternPayload;

class InternRepository {
    private PDO $connection;

    public function __construct($connection)
    {
        $this->connection=$connection;
    }

    public function getAllIntern(){
        $sql= "SELECT i.id as intern_id, i.first_name, i.last_name, g.id as group_id ,g.group_name
               FROM intern i INNER JOIN groupQ g on i.group_id=g.id";

        try {
            $query = $this->connection->query($sql);
            $result= $query->fetchAll(PDO::FETCH_ASSOC);
            $interns=array();

            foreach( $result as $intern ) {
                array_push($interns,
                new InternFull($intern["intern_id"],$intern["first_name"],$intern["last_name"], new GroupPayload($intern["group_name"])));
            }

            return $interns;
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
    public function getInternById(int $id){
        $sql= "SELECT i.id as intern_id, i.first_name, i.last_name, g.id as group_id ,g.group_name
               FROM intern i INNER JOIN groupQ g on i.group_id=g.id
               WHERE i.id=:intern_id";

        try {
            $query = $this->connection->prepare($sql);

            $query->execute(["intern_id"=>$id]);
            $result= $query->fetchAll(PDO::FETCH_ASSOC);


            return new InternFull(
                intval($result[0]["intern_id"]),
                $result[0]["first_name"],
                $result[0]["last_name"],
                new GroupPayload($result[0]["group_name"])
            );
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
}