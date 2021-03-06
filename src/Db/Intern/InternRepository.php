<?php

namespace PhpApi\Db\Intern;

use \PDO;
use \PDOException;
use PhpApi\Model\Group\Group;
use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Intern\Intern;
use PhpApi\Model\Intern\InternData;
use PhpApi\Model\Intern\InternDataId;
use PhpApi\Model\Intern\InternFull;
use PhpApi\Model\Intern\InternPayload;

class InternRepository {
    private PDO $connection;

    public function __construct($connection)
    {
        $this->connection=$connection;
    }

    public function getAllIntern($limit, $page,$sort,$order ){

       if($sort !==null && $order === null) {
           $orderBy=" ORDER BY ".$sort." asc ";
       } elseif( $sort ===null && $order!== null) {
           $orderBy=" ORDER BY id ".$order." ";
       } elseif( $sort!==null && $order !==null) {
           $orderBy= " ORDER BY ".$sort." ".$order." ";
       } else {
           $orderBy= " ORDER BY id asc ";
       }

        $pagination=" ";
        if($limit !== null && $page !== null) {
            $pagination = " LIMIT " . intval($limit) . " OFFSET " . intval($page);
        } elseif ( $limit !==null && $page === null) {
            $pagination= " LIMIT ".intval($limit);
        }
        $sql= "SELECT i.id as id, i.first_name as first_name, i.last_name as last_name, g.id as group_id ,g.group_name as group_name
               FROM intern i INNER JOIN groupQ g on i.group_id=g.id ".$orderBy.$pagination;

        try {
            $query = $this->connection->query($sql);
            $result= $query->fetchAll(PDO::FETCH_ASSOC);
            $interns=array();

            foreach( $result as $intern ) {
                array_push($interns,
                new InternFull($intern["id"],$intern["first_name"],$intern["last_name"], new GroupPayload($intern["group_name"])));
            }

            return $interns;
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
    public function getInternById(int $id){
        $sql= "SELECT i.id as intern_id, i.first_name, i.last_name, g.id as group_id ,g.group_name, c.text, c.date
               FROM intern i INNER JOIN groupQ g on i.group_id=g.id INNER JOIN comment c on i.id = c.intern_id
               WHERE i.id= :intern_id
               order by c.date asc";
 echo "getInternById";
        try {
            $query = $this->connection->prepare($sql);

            $query->execute(["intern_id"=>$id]);
            $result= $query->fetchAll(PDO::FETCH_ASSOC);


            $intern= new InternFull(
                intval($result[0]["intern_id"]),
                $result[0]["first_name"],
                $result[0]["last_name"],
                new GroupPayload($result[0]["group_name"])
            );
            $comments=array();
            foreach ($result as $comment){
                $i=0;
                $comments[$i]["text"]=$comment["text"];
                $comments[$i]["date"]=$comment["date"];
                $i=$i+1;
            }
            return array("intern"=>$intern,
                "comments"=>$comments);
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function insert(InternData $internData) {
        $sql = "INSERT INTO intern (first_name, last_name, group_id) VALUES (:first_name, :last_name, :group_id)";
        try {
            $query=$this->connection->prepare($sql);
            $query->execute([
                "first_name" => $internData->firstName,
                "last_name" => $internData->lastName,
                "group_id" => $internData->groupId
            ]);

            return new InternDataId(
                $this->connection->lastInsertId(),
                $internData->firstName,
                $internData->lastName,
                $internData->groupId
            );

        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }

    }

    public function update(InternDataId $intern)
    {
        $sql = "UPDATE intern SET first_name= :first_name, last_name= :last_name, group_id= :group_id WHERE id = :id";
        try {
            $query=$this->connection->prepare($sql);

            $query->execute([
               "first_name" => $intern->firstName,
               "last_name" => $intern->lastName,
               "group_id" => $intern->groupId,
                "id" => $intern->id
            ]);
            return $intern;
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function delete(int $id) {
        $sql = "DELETE FROM intern WHERE id = :id";
        try {
            $query = $this->connection->prepare($sql);
            $query->execute(["id" => $id]);
        } catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
}