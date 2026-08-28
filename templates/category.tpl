{extends file='layouts/main.tpl'}

{block name=title}Категория: {$category.name|escape}{/block}

{block name=content}
    <a href="/" class="back-link">← На главную</a>

    <h1>{$category.name|escape}</h1>
    <p class="category-desc">{$category.description|escape}</p>

    <!-- Панель сортировки -->
    <div class="sort-panel">
        <strong>Сортировать по:</strong>
        <a href="?sort=created_at&order=desc" class="{if $current_sort == 'created_at'}active{/if}">Дате (новые)</a> |
        <a href="?sort=views&order=desc" class="{if $current_sort == 'views'}active{/if}">Популярности (просмотры)</a>
    </div>

    <!-- Сетка статей -->
    <div class="articles-grid">
        {foreach $articles as $article}
            <article class="article-card">
                <img src="/images/{$article.image|default:'default.jpg'}" alt="{$article.title|escape}">
                <h3><a href="/article/{$article.id}">{$article.title|escape}</a></h3>
                <p>{$article.description|escape}</p>
                <small class="card-meta">👀 Просмотров: {$article.views} | 📅 {$article.created_at}</small>
            </article>
            {foreachelse}
            <p>В этой категории пока нет статей.</p>
        {/foreach}
    </div>

    <!-- Блок пагинации -->
    {if $total_pages > 1}
        {assign var="current_order" value="desc"}
        {if isset($smarty.get.order)}
            {assign var="current_order" value=$smarty.get.order|escape}
        {/if}

        <div class="pagination">
            {for $p=1 to $total_pages}
                <a href="?page={$p}&sort={$current_sort}&order={$current_order}"
                   class="page-link {if $current_page == $p}active{/if}">
                    {$p}
                </a>
            {/for}
        </div>
    {/if}
{/block}
