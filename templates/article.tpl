{extends file='layouts/main.tpl'}

{block name=title}{$article.title|escape}{/block}

{block name=content}
    <article style="margin-bottom: 50px;">
        <header style="margin-bottom: 20px;">
            <h1>{$article.title|escape}</h1>
            <div style="color: #888; margin-bottom: 15px;">
                <span>📅 Дата публикации: {$article.created_at}</span> |
                <span>👀 Просмотров: {$article.views}</span>
            </div>
            {if $article.image}
                <img src="/images/{$article.image}" alt="{$article.title|escape}" style="max-width: 100%; height: auto; border-radius: 8px;">
            {/if}
        </header>

        <div style="font-size: 1.1em; line-height: 1.6; color: #333;">
            {$article.text|nl2br}
        </div>
    </article>

    {if !empty($similar)}
        <section style="background: #f9f9f9; padding: 25px; border-radius: 6px; border-top: 4px solid #007bff;">
            <h3>Рекомендуем почитать</h3>
            <div class="articles-grid">
                {foreach $similar as $sim}
                    <div class="article-card" style="background: #fff;">
                        <h4><a href="/article/{$sim.id}" style="color: #007bff; text-decoration: none;">{$sim.title|escape}</a></h4>
                        <p style="font-size: 0.9em; color: #666;">{$sim.description|truncate:90:"..."|escape}</p>
                    </div>
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
