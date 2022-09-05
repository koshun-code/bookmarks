<?php

namespace BM\Model;
use BM\Model\Model;
use PDO;
use PDOException;

class CategoryModel extends Model
{
    public function getBookmarksByCategory($id)
    {
        $sql = "SELECT id, name, url, status FROM bookmarks INNER JOIN category ON bookmarks.category_id=category.id_category WHERE bookmarks.category_id = ?";
        try {
            $sthm = $this->db->prepare($sql);
            $sthm->execute([$id]);
            return $sthm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}