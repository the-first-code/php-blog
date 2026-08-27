<?php

namespace App\Models;

use App\Services\Database;
use PDO;

class Article {
    public function getPaginatedByCategory(int $categoryId, string $sort, string $order, int $limit, int $offset): array {
        $db = Database::getConnection();
        $allowedSorts = ['views', 'created_at'];
        $sort = in_array($sort, $allowedSorts) ? $sort : 'created_at';
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $stmt = $db->prepare("
            SELECT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = ?
            ORDER BY $sort $order
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCountByCategory(int $categoryId): int {
        $stmt = Database::getConnection()->prepare("
            SELECT COUNT(*) FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = ?
        ");
        $stmt->execute([$categoryId]);
        return (int)$stmt->fetchColumn();
    }

    public function find(int $id): ?array {
        $stmt = Database::getConnection()->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function incrementViews(int $id): void {
        Database::getConnection()->prepare("UPDATE articles SET views = views + 1 WHERE id = ?")->execute([$id]);
    }

    public function getSimilar(int $articleId, int $categoryId, int $limit = 3): array {
        $stmt = Database::getConnection()->prepare("
            SELECT DISTINCT a.* FROM articles a
            JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = ? AND a.id != ?
            ORDER BY a.created_at DESC LIMIT ?
        ");
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $articleId, PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
