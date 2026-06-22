{if isset($productBadges) && $productBadges}
    <div class="product-badges-list product-list-badges">
        {foreach $productBadges as $badge}
            <span
                class="product-badge"
                style="background-color: {$badge.color|escape:'html':'UTF-8'};"
            >
                {$badge.label|escape:'html':'UTF-8'}
            </span>
        {/foreach}
    </div>
{/if}