<?php

namespace BM\Model;

use BM\Exceptions\DeleteException;
use BM\Exceptions\ExistException;
use BM\Exceptions\FindException;
use BM\Exceptions\GetException;
use BM\Exceptions\InsertException;
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
        
        $execute = $sth->execute(); 
        if ($execute) {
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new GetException('Не могу получить данные от сервера');
        }
    }

    public function getOne($id, $table = 'bookmarks')
    {
        $sth = $this->db->prepare("SELECT * FROM {$table} WHERE id = ?");
        $execute = $sth->execute([$id]);
        if ($execute) {
            return $sth->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new GetException('Не могу получить данные от сервера');
        }
    }

    public function find(array $data, array $param, string $where, string $table)
    {
        $param = join(', ', $param);
        $sql = "SELECT {$param} FROM {$table} WHERE {$where} = ?";
        $sth = $this->db->prepare($sql);
        $execute = $sth->execute($data);
        if ($execute) {
            return $sth->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new FindException('Невозможно найти запрашиваемые данные');
        }
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
            $sth = $this->db->prepare($sql);
            $insert = $sth->execute($data);
            if ($insert) {
                return $this->db->lastInsertId();
            } else {
                throw new InsertException('Невозможно внести данные. Проверти их корректность');
            }
    }
    public function isExist($table, $where, $item)
    {
        $sql = "SELECT {$where} FROM {$table} WHERE {$where} = ?";
        $sth = $this->db->prepare($sql);
        $exist = $sth->execute([$item]);
        if ($exist) {
            return $sth->rowCount() > 0;
        } else {
            throw new ExistException('Невожможно выполнить запрос');
        }
    }
}