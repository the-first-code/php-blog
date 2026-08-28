<?php

namespace App\Services;

use Faker\Factory;
use PDO;

class Seeder {
    public static function run(): void {
        $db = Database::getConnection();

        $faker = Factory::create('ru_RU');

        // Очищаем старые данные
        $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $db->exec("TRUNCATE TABLE article_category;");
        $db->exec("TRUNCATE TABLE articles;");
        $db->exec("TRUNCATE TABLE categories;");
        $db->exec("SET FOREIGN_KEY_CHECKS = 1;");

        $categoryNames = ['Технологии', 'Путешествия', 'Дизайн', 'Программирование', 'Лайфстайл'];
        $categoryIds = [];

        foreach ($categoryNames as $name) {
            $stmt = $db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
            $stmt->execute([
                $name,
                $faker->realText(150)
            ]);
            $categoryIds[] = $db->lastInsertId();
        }

        for ($i = 1; $i <= 30; $i++) {
            $title = rtrim($faker->realText(40), '.');

            $description = $faker->realText(120);

            // Настоящий большой текст статьи из нескольких абзацев
            $paragraphs = [];
            for ($j = 0; $j < 4; $j++) {
                $paragraphs[] = $faker->realText(400);
            }
            $text = implode("\n\n", $paragraphs);

            $stmt = $db->prepare("INSERT INTO articles (image, title, description, text, views) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                "default.jpg",
                $title,
                $description,
                $text,
                rand(0, 1500)
            ]);

            $articleId = $db->lastInsertId();

            // Привязываем статью к одной или нескольким случайным категориям
            $shuffledCategories = $categoryIds;
            shuffle($shuffledCategories);

            $categoriesCount = rand(1, 2);
            for ($c = 0; $c < $categoriesCount; $c++) {
                $db->prepare("INSERT INTO article_category (article_id, category_id) VALUES (?, ?)")
                    ->execute([$articleId, $shuffledCategories[$c]]);
            }
        }

        echo "Faker Seeding completed successfully! Generated 5 categories and 30 articles.\n";
    }
}
