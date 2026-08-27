<?php

namespace App\Models;

use App\Services\Database;
use PDO;

class Category {
    public function getAllWithArticlesLimit(int $limit = 3): array {
        $db = Database::getConnection();
        $categories = $db->query("SELECT * FROM categories")->fetchAll();

        $result = [];
        foreach ($categories as $cat) {
            $stmt = $db->prepare("
                SELECT a.* FROM articles a
                JOIN article_category ac ON a.id = ac.article_id
                WHERE ac.category_id = ?
                ORDER BY a.created_at DESC LIMIT ?
            ");
            $stmt->bindValue(1, $cat['id'], PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $articles = $stmt->fetchAll();

            if (!empty($articles)) {
                $cat['articles'] = $articles;
                $result[] = $cat;
            }
        }
        return $result;
    }

    public function find(int $id): ?array {
        $stmt = Database::getConnection()->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }
}
