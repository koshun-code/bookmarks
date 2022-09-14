<?php

namespace BM\Model;

use BM\Exceptions\GetException;
use BM\Model\Model;
use PDO;
use PDOException;

class CategoryModel extends Model
{
    public function getBookmarksByCategory($id)
    {
        $sql = "SELECT id, name, url, status FROM bookmarks INNER JOIN category ON bookmarks.category_id=category.id_category WHERE bookmarks.category_id = ?";
        $sthm = $this->db->prepare($sql);
        $get = $sthm->execute([$id]);
        if ($get) {
            return $sthm->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new GetException('Невозможно получить данные');
        }
  
    }
}