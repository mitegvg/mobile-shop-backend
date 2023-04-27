<?php
namespace Src\TableGateways;

class DevicesGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, model, brand, release_date, os, is_new, received_datatime, created_datetime, update_datetime
            FROM
                devices;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
            SELECT 
                id, model, brand, release_date, os, is_new, received_datatime, created_datetime, update_datetime
            FROM
                devices
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id'=>$id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO devices 
                (id, model, brand, release_date, os, is_new, received_datatime)
            VALUES
                (:id, :model, :brand, :release_date, :os, :is_new, :received_datatime);
        ";
        
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => uniqid(),
                'model' => $input['model'],
                'brand'  => $input['brand'],
                'release_date' => $input['release_date'] ?? null,
                'os' => $input['os'] ?? null,
                'is_new' => $input['is_new'] ?? null,
                'received_datatime' => $input['received_datatime'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            return $e->getMessage();
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE devices
            SET 
                model = :model,
                brand  = :brand,
                release_date = :release_date,
                os = :os,
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => $id,
                'model' => $input['model'],
                'brand'  => $input['brand'],
                'release_date' => $input['release_date'] ?? null,
                'os' => $input['os'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM devices
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}