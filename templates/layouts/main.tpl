<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}Мой Блог{/block}</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header style="background: #333; padding: 15px 0; margin-bottom: 30px;">
    <div style="max-width: 1000px; margin: auto; padding: 0 20px;">
        <a href="/" style="color: #fff; text-decoration: none; font-size: 24px; font-weight: bold;">🏠 Чистый PHP Блог</a>
    </div>
</header>

<main class="container">
    {block name=content}{/block}
</main>

<footer style="margin-top: 50px; text-align: center; color: #888; padding: 20px 0; border-top: 1px solid #ddd;">
    &copy; 2026 Чистый PHP Блог на Smarty & Docker
</footer>
</body>
</html>
