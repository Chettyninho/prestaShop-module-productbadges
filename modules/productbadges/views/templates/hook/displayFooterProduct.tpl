{if isset($productBadges) && $productBadges}
    <div class="product-badges-list product-footer-badges">
        {foreach $productBadges as $badge}
            <span class="product-badge" style="background: {$badge.color};">{$badge.label|escape:'html':'UTF-8'}</span>
        {/foreach}
    </div>
{/if}
