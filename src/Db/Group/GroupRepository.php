<?php

namespace PhpApi\Db\Group;

use \PDO;
use \PDOException;
use PhpApi\Model\Group\GroupFull;
use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Group\Group;
use PhpApi\Model\Intern\InternPayload;
use PhpApi\Model\Mentor\MentorPayload;

class GroupRepository {
    private PDO $connection;
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAllGroup() {
        $sql="SELECT id, group_name FROM groupQ";

        try {
            $query=$this->connection->query($sql);
            $result=$query->fetchAll(PDO::FETCH_ASSOC);

            return array_map(
                function ($r){
                    return new Group(
                        intval($r["id"]),
                        $r["group_name"]
                    );
                },
                $result
            );
        }catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function getGroupById(int $id){
        $sql="SELECT g.id as group_id, g.group_name, i.id as intern_id, i.first_name as intern_first_name, i.last_name as intern_last_name, m.id as mentor_id, m.first_name as mentor_first_name, m.last_name as mentor_last_name
              FROM groupQ g inner join intern i on g.id=i.group_id inner join mentor m on g.id=m.group_id
              WHERE g.id= :id";

        try {
            $query=$this->connection->prepare($sql);
            $query->execute(["id"=>$id]);
            $result=$query->fetchAll(PDO::FETCH_ASSOC);

            $groupId=$result[0]["group_id"];
            $groupName=$result[0]["group_name"];

            $mentors=array();
            foreach ($result as $mentor){
                $mId = $mentor["mentor_id"];
                $mentors[$mId]["first_name"]=$mentor["mentor_first_name"];
                $mentors[$mId]["last_name"]=$mentor["mentor_last_name"];
            }

            $interns=array();
            foreach ($result as $intern){
                $iId = $intern["intern_id"];
                $interns[$iId]["first_name"]=$intern["intern_first_name"];
                $interns[$iId]["last_name"]=$intern["intern_last_name"];
            }
            $mentorsM=array();
            foreach ($mentors as $mentor) {
                array_push($mentorsM, new MentorPayload($mentor["first_name"],$mentor["last_name"]));
            }
            $internsI=array();
            foreach ($interns as $intern) {
                array_push($internsI, new InternPayload($intern["first_name"],$intern["last_name"]));
            }

            $groupFull= new GroupFull($groupId,$groupName,$mentorsM,$internsI);

            return $groupFull;

        }catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function insertGroup(GroupPayload $payload){
        $sql="INSERT INTO groupQ (group_name) VALUES ( :gruop_name)";
        try {
            $query=$this->connection->prepare($sql);
            $query->execute([
               "gruop_name" => $payload->groupName
            ]);
            return new Group(
                $this->connection->lastInsertId(),
                $payload->groupName
            );
        }catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
    public function updateGroup(Group $group) {
        $sql = "UPDATE groupQ SET group_name= :group_name WHERE id= :id";
        try {
            $query=$this->connection->prepare($sql);
            $query->execute([
               "group_name"=>$group->groupName,
               "id"=>$group->id
            ]);
            return $group;
        }catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
    public function deleteGroup(int $id) {
        $sql = "DELETE from groupQ WHERE id=:id ";
        try {
            $query = $this->connection->prepare($sql);
            $query->execute([
               "id"=>$id
            ]);
        }catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
}