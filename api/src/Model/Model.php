<?php

namespace BM\Model;

use BM\Exceptions\DeleteException;
use BM\Model\DBConnect;
use Exception;
use PDO;
use PDOException;

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

    public function find(array $data, array $param, string $where, string $table)
    {
        $param = join(', ', $param);
        $sql = "SELECT {$param} FROM {$table} WHERE {$where} = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute($data);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id, string $table = 'bookmarks')
    {
        $sql = "DELETE FROM {$table} WHERE id = ?";
        $sth = $this->db->prepare($sql);
        $deleted = $sth->execute([$id]);
        if ($deleted) {
            return true;
        } else {
            throw new DeleteException('Невозможно удалить');
        }
    }

    public function insert(array $data, array $fields, string $table = 'bookmarks'): int | string
    { 
        $plaseholders = array_map(fn($plaseholder) => ":{$plaseholder}", $fields);
        $fields = join(', ', $fields);
        $plaseholders = join(', ', $plaseholders);
        
        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$plaseholders})";
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute($data);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function isExist($table, $where, $item)
    {
        $sql = "SELECT {$where} FROM {$table} WHERE {$where} = ?";
        $sth = $this->db->prepare($sql);
        $sth->execute([$item]);
        return $sth->rowCount() > 0;

    }
}