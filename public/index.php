<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\BlogController;
use App\Services\ScssCompiler;

ScssCompiler::compileIfNeeded();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$controller = new BlogController();

if ($uri === '/' || $uri === '') {
    $controller->index();
} elseif (preg_match('#^/category/(\d+)$#', $uri, $matches)) {
    $controller->category((int)$matches[1], $_GET);
} elseif (preg_match('#^/article/(\d+)$#', $uri, $matches)) {
    $controller->article((int)$matches[1]);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Page not found";
}
