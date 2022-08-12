<?php

namespace BM\Model;

use BM\Model\DBConnect;
use PDO;

class Model {
    
    protected $db;

    public function __construct()
    {
        $pdo = new DBConnect();
        $this->db = $pdo->setConnection();
    }
    public function getALL($table = 'bookmarks')
    {
        $sth = $this->db->prepare("SELECT * FROM {$table}");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($id, $table = 'bookmarks')
    {
        $sth = $this->db->prepare("SELECT * FROM {$table} WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id, $table = 'bookmarks')
    {
        $sql = "DELETE FROM {$table} WHERE id = ?";
        $sth = $this->db->prepare($sql);
        return $sth->execute([$id]);
    }

    public function insert($data, $fields, $plaseholders, $table = 'bookmarks')
    { 
        $fields = join(', ', $fields);
        $plaseholders = join(', ', $plaseholders);
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$plaseholders})";
        $sth = $this->db->prepare($sql);
        $sth->execute($data);

        return $this->db->lastInsertId();
    }
}