<?php

namespace PhpApi\Db\Comment;

use PhpApi\Model\Comment\Comment;

class CommentRepository
{
    private \PDO $connection;

    public function __construct($connection)
    {
        $this->connection=$connection;
    }

    public function approve($mentorId, $internId){
        $sql = "SELECT * from mentor m inner join intern i on i.group_id=m.group_id 
                WHERE i.id= :intern_id and m.id = :mentor_id";
        try {
            $query=$this->connection->prepare($sql);
            $query->execute([
                "intern_id"=>$internId,
                "mentor_id"=>$mentorId
            ]);
            $result=$query->fetchAll(\PDO::FETCH_ASSOC);
            if(empty($result)){
                return false;
            }
            else {
                return true;
            }

        }catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }

    }

    public function insertGroup($text, $mentorId, $internId)
    {
        $sql= "INSERT INTO comment (text, intern_id, mentor_id) VALUES (:text, :intern_id, :mentor_id)";
        try {
            $query=$this->connection->prepare($sql);
            $query->execute([
                "text"=>$text,
                "intern_id"=>$internId,
                "mentor_id"=>$mentorId
            ]);
            $id=$this->connection->lastInsertId();
            $sqlDate="SELECT date from comment WHERE id= :id";
            $queryDate=$this->connection->prepare($sqlDate);
            $queryDate->execute(["id"=>$id]);
            $resultDate=$queryDate->fetchAll(\PDO::FETCH_ASSOC);
            $date= $resultDate[0]["date"];
            return new Comment(
                $id,
                $text,
                $date,
                $internId,
                $mentorId
            );

        }catch (\PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

    public function deleteComment($id,$mentorId) {
        $sql = "DELETE from comment WHERE id=:id and mentor_id= :mentor_id";
        try {
            $query = $this->connection->prepare($sql);
            $query->execute([
                "id"=>$id,
                "mentor_id"=>$mentorId
            ]);

        }catch (PDOException $e) {
            exit($e->getMessage().PHP_EOL);
        }
    }

}