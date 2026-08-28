<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}Мой Блог{/block}</title>
    <link rel="stylesheet" href="/css/style.css?v=2">
</head>
<body>
<header class="main-header">
    <div class="header-container">
        <a href="/" class="logo">🏠 Чистый PHP Блог</a>
    </div>
</header>

<main class="container">
    {block name=content}{/block}
</main>

<footer class="main-footer">
    &copy; 2026 Чистый PHP Блог на Smarty & Docker
</footer>
</body>
</html>
