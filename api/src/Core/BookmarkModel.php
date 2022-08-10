<?php

namespace BM\Core;

use BM\Core\DBConnect;
use PDO;

class BookmarkModel
{
    private $db;

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

    public function insert($data, $table = 'bookmarks')
    { 
        //var_dump($data);
        $sql = "INSERT INTO {$table} ( name, url, status) VALUES (:name, :url, :status)";
        $sth = $this->db->prepare($sql);
        return $sth->execute($data);
    }
    public function deleteBookmark($id, $table = 'bookmarks')
    {
        $sql = "DELETE FROM {$table} WHERE id = ?";
        $sth = $this->db->prepare($sql);
        return $sth->execute([$id]);
    }
}