{extends file='layouts/main.tpl'}

{block name=title}{$article.title|escape}{/block}

{block name=content}
    <article class="full-article">
        <header class="article-header">
            <a href="/" class="back-link">← На главную</a>
            <h1>{$article.title|escape}</h1>
            <div class="article-meta">
                <span>📅 Дата публикации: {$article.created_at}</span> |
                <span>👀 Просмотров: {$article.views}</span>
            </div>
            {if $article.image}
                <img src="/images/{$article.image}" alt="{$article.title|escape}" class="article-cover">
            {/if}
        </header>

        <div class="article-body">
            {$article.text|nl2br}
        </div>
    </article>

    <!-- Похожие статьи -->
    {if !empty($similar)}
        <section class="similar-section">
            <h3>Рекомендуем почитать</h3>
            <div class="articles-grid">
                {foreach $similar as $sim}
                    <div class="article-card similar-card">
                        <h4><a href="/article/{$sim.id}">{$sim.title|escape}</a></h4>
                        <p>{$sim.description|truncate:90:"..."|escape}</p>
                    </div>
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
