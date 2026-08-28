{extends file='layouts/main.tpl'}

{block name=title}Главная страница — Блог{/block}

{block name=content}
    <h1>Последние публикации по категориям</h1>

    {foreach $categories as $cat}
        <section class="category-section">
            <h2>{$cat.name|escape}</h2>
            <p class="category-desc">{$cat.description|escape}</p>

            <div class="articles-grid">
                {foreach $cat.articles as $article}
                    <article class="article-card">
                        <img src="/images/{$article.image|default:'default.jpg'}" alt="{$article.title|escape}">
                        <h3><a href="/article/{$article.id}">{$article.title|escape}</a></h3>
                        <p>{$article.description|truncate:120:"..."|escape}</p>
                        <small class="card-meta">👀 Просмотры: {$article.views} | 📅 {$article.created_at}</small>
                    </article>
                {/foreach}
            </div>

            <a href="/category/{$cat.id}" class="btn category-btn">Все статьи категории →</a>
        </section>
    {/foreach}
{/block}
