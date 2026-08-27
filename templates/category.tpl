{extends file='layouts/main.tpl'}

{block name=title}{$category.name|escape} — Категория{/block}

{block name=content}
    <a href="/" style="text-decoration: none; color: #007bff;">← На главную</a>

    <h1 style="margin-top: 15px;">{$category.name|escape}</h1>
    <p style="font-size: 1.1em; color: #555;">{$category.description|escape}</p>

    <div style="background: #f0f4f8; padding: 10px 15px; border-radius: 4px; margin-bottom: 25px;">
        <strong>Сортировать по:</strong>
        <a href="?sort=created_at&order=desc" style="{if $current_sort == 'created_at'}font-weight: bold;{/if} margin-left: 10px;">Дате (новые)</a> |
        <a href="?sort=views&order=desc" style="{if $current_sort == 'views'}font-weight: bold;{/if}">Популярности (просмотры)</a>
    </div>

    <div class="articles-grid">
        {foreach $articles as $article}
            <article class="article-card">
                <img src="/images/{$article.image|default:'default.jpg'}" alt="{$article.title|escape}">
                <h3><a href="/article/{$article.id}" style="color: #333; text-decoration: none;">{$article.title|escape}</a></h3>
                <p>{$article.description|escape}</p>
                <small style="color: #999;">👀 Просмотров: {$article.views} | 📅 {$article.created_at}</small>
            </article>
            {foreachelse}
            <p>В этой категории пока нет статей.</p>
        {/foreach}
    </div>

    <!-- Пагинация -->
    {if $total_pages > 1}
        {* Определяем текущее направление сортировки, чтобы не сломать синтаксис внутри ссылок *}
        {assign var="current_order" value="desc"}
        {if isset($smarty.get.order)}
            {assign var="current_order" value=$smarty.get.order|escape}
        {/if}

        <div class="pagination" style="margin-top: 30px; display: flex; gap: 5px;">
            {for $p=1 to $total_pages}
                {* Заранее вычисляем стили для активной и пассивных страниц *}
                {if $current_page == $p}
                    {assign var="pg_bg" value="#007bff"}
                    {assign var="pg_color" value="#fff"}
                {else}
                    {assign var="pg_bg" value="#fff"}
                    {assign var="pg_color" value="#007bff"}
                {/if}

                <a href="?page={$p}&sort={$current_sort}&order={$current_order}"
                   style="padding: 8px 14px; text-decoration: none; border: 1px solid #007bff; border-radius: 4px; background: {$pg_bg}; color: {$pg_color}; font-weight: bold;">
                    {$p}
                </a>
            {/for}
        </div>
    {/if}
{/block}
