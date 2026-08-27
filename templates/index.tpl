{extends file='layouts/main.tpl'}

{block name=title}Главная страница — Блог{/block}

{block name=content}
    <h1>Последние публикации по категориям</h1>

    {foreach $categories as $cat}
        <section class="category-section">
            <h2>{$cat.name|escape}</h2>
            <p style="color: #666; font-style: italic;">{$cat.description|escape}</p>

            <div class="articles-grid">
                {foreach $cat.articles as $article}
                    <article class="article-card">
                        <img src="/images/{$article.image|default:'default.jpg'}" alt="{$article.title|escape}">
                        <h3><a href="/article/{$article.id}" style="color: #333; text-decoration: none;">{$article.title|escape}</a></h3>
                        <p>{$article.description|truncate:120:"..."|escape}</p>
                        <small style="color: #999;">👀 Просмотры: {$article.views} | 📅 {$article.created_at}</small>
                    </article>
                {/foreach}
            </div>

            <a href="/category/{$cat.id}" class="btn" style="margin-top: 15px;">Все статьи категории →</a>
        </section>
    {/foreach}
{/block}
