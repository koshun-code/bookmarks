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

    public function getALL()
    {
        $sth = $this->db->prepare("SELECT * FROM bookmarks");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOne($id)
    {
        $sth = $this->db->prepare("SELECT * FROM bookmarks WHERE id = ?");
        $sth->execute([$id]);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data, $table = 'bookmarks')
    { 
        $sql = "INSERT INTO {$table} ( name, url) VALUES (:name, :url)";
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