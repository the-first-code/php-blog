<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Article;
use Smarty;

class BlogController {
    private Smarty $smarty;

    public function __construct() {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../../templates');
        $this->smarty->setCompileDir(__DIR__ . '/../../storage/templates_c');
    }

    public function index(): void {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllWithArticlesLimit(3);

        $this->smarty->assign('categories', $categories);
        $this->smarty->display('index.tpl');
    }

    public function category(int $id, array $params): void {
        $categoryModel = new Category();
        $category = $categoryModel->find($id);

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            echo "Category not found";
            return;
        }

        $sort = $params['sort'] ?? 'created_at';
        $order = $params['order'] ?? 'DESC';
        $page = (int)($params['page'] ?? 1);
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $articleModel = new Article();
        $articles = $articleModel->getPaginatedByCategory($id, $sort, $order, $limit, $offset);
        $totalArticles = $articleModel->getCountByCategory($id);
        $totalPages = ceil($totalArticles / $limit);

        $this->smarty->assign('category', $category);
        $this->smarty->assign('articles', $articles);
        $this->smarty->assign('current_page', $page);
        $this->smarty->assign('total_pages', $totalPages);
        $this->smarty->assign('current_sort', $sort);
        $this->smarty->display('category.tpl');
    }

    public function article(int $id): void {
        $articleModel = new Article();
        $articleModel->incrementViews($id);
        $article = $articleModel->find($id);

        if (!$article) {
            header("HTTP/1.0 404 Not Found");
            echo "Article not found";
            return;
        }

        $db = \App\Services\Database::getConnection();
        $catStmt = $db->prepare("SELECT category_id FROM article_category WHERE article_id = ? LIMIT 1");
        $catStmt->execute([$id]);
        $catId = $catStmt->fetchColumn() ?: 0;

        $similar = $articleModel->getSimilar($id, $catId, 3);

        $this->smarty->assign('article', $article);
        $this->smarty->assign('similar', $similar);
        $this->smarty->display('article.tpl');
    }
}
