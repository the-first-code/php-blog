<?php

namespace App\Services;

class Seeder {
    public static function run(): void {
        $db = Database::getConnection();

        $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $db->exec("TRUNCATE TABLE article_category;");
        $db->exec("TRUNCATE TABLE articles;");
        $db->exec("TRUNCATE TABLE categories;");
        $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

        for ($i = 1; $i <= 5; $i++) {
            $stmt = $db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
            $stmt->execute(["Категория $i", "Описание категории номер $i"]);
        }

        for ($i = 1; $i <= 15; $i++) {
            $stmt = $db->prepare("INSERT INTO articles (image, title, description, text, views) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                "default.jpg",
                "Статья блога №$i",
                "Короткое описание статьи $i...",
                "Полный подробный текст статьи номер $i, содержащий много полезной информации.",
                rand(10, 500)
            ]);

            $articleId = $db->lastInsertId();
            $catId = rand(1, 5);
            $db->prepare("INSERT INTO article_category (article_id, category_id) VALUES (?, ?)")->execute([$articleId, $catId]);
        }

        echo "Seeding completed!\n";
    }
}
