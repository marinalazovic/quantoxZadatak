<?php

namespace PhpApi\Db\Mentor;

use PDO;
use PhpApi\Model\Group\GroupPayload;
use PhpApi\Model\Mentor\MentorData;
use PhpApi\Model\Mentor\MentorDataId;
use PhpApi\Model\Mentor\MentorFull;
use PhpApi\Model\Mentor\MentorPayload;

class MentorRepository {
    private PDO $connection;

    public function __construct($connection)
    {
        $this->connection=$connection;
    }

    public function getAllMentors($sort="id", $order="asc",$limit, $page) {
        $pagination="";
        if($limit !== null && $page !== null)
            $pagination=" LIMIT ".intval($limit)." OFFSET ".intval($page);
        $sql = "SELECT m.id as id, m.first_name, m.last_name, m.years_of_experience, g.group_name
                FROM mentor m INNER JOIN groupQ g on m.group_id = g.id
                ORDER BY ".$sort." ".$order.$pagination;
        try {
            $query = $this->connection->query($sql);
            $result=$query->fetchAll(PDO::FETCH_ASSOC);
            return array_map(
                function ($r) {
                    return new MentorFull(
                        intval($r["id"]),
                        $r["first_name"],
                        $r["last_name"],
                        intval($r["years_of_experience"]),
                        new GroupPayload( $r["group_name"])
                    );
                },
                $result
            );

        } catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function  getMentorById(int $id) {
        $sql = "SELECT m.id, m.first_name, m.last_name, m.years_of_experience, g.group_name
                FROM mentor m INNER JOIN groupQ g on m.group_id = g.id
                WHERE m.id = :id";

        try {
            $query = $this->connection->prepare($sql);
            $query->execute(["id"=>$id]);
            $result=$query->fetchAll(PDO::FETCH_ASSOC);

            return new MentorFull(
                intval($result[0]["id"]),
                $result[0]["first_name"],
                $result[0]["last_name"],
                $result[0]["years_of_experience"],
                new GroupPayload($result[0]["group_name"])
            );

        } catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function insert(MentorData $mentorData) {
        $sql = "INSERT INTO mentor (first_name, last_name, years_of_experience, group_id) VALUES (:first_name, :last_name, :years_of_experience, :group_id)";

        try {
            $query = $this->connection->prepare($sql);
            $query->execute([
                "first_name"=> $mentorData->firstName,
                "last_name"=> $mentorData->lastName,
                "years_of_experience"=> $mentorData->yearsOfExperience,
                "group_id"=> $mentorData->groupId
            ]);
            return new MentorDataId(
                $this->connection->lastInsertId(),
                $mentorData->firstName,
                $mentorData->lastName,
                $mentorData->yearsOfExperience,
                $mentorData->groupId
            );

        } catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function update(MentorDataId $mentor) {
        $sql = "UPDATE mentor 
                SET first_name = :first_name, last_name = :last_name, years_of_experience = :years_od_experience, group_id = :group_id
                WHERE id = :id";

        try {
            $query = $this->connection->prepare($sql);
            $query->execute([
               "first_name"=> $mentor->firstName,
               "last_name"=> $mentor->lastName,
               "years_od_experience" => $mentor->yearsOfExperience,
                "group_id" => $mentor->groupId,
                "id" => $mentor->id
            ]);
            return $mentor;
        } catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM mentor WHERE id = :id";

        try {
            $query= $this->connection->prepare($sql);
            $query->execute(["id"=>$id]);

        } catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }
}