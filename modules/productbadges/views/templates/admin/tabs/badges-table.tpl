<div class="panel">
    <h3>Assign Badge</h3>

    <form method="post">

        {if isset($editingAssignment)}
            <input
                type="hidden"
                name="id_assignment"
                value="{$editingAssignment.id_product_badges_product}">
        {/if}

        <div class="form-group">
            <label>Badge</label>

            <select
                name="id_product_badge"
                class="form-control"
                required
            >
                <option value="">Select badge</option>

                {foreach $badgeOptions as $badge}
                    <option value="{$badge.id_badge}"
                        {if isset($editingAssignment) && $editingAssignment.id_product_badge == $badge.id_badge}
                            selected="selected"
                        {/if}>
                        {$badge.name}
                    </option>
                {/foreach}

            </select>
        </div>

        <div class="form-group">
            <label>Product</label>

            <select
                name="id_product"
                class="form-control"
                required
            >
                <option value="">Select product</option>

                {foreach $productOptions as $product}
                    <option value="{$product.id_product}"
                        {if isset($editingAssignment) && $editingAssignment.id_product == $product.id_product}
                            selected="selected"
                        {/if}>
                        {$product.name}
                    </option>
                {/foreach}

            </select>
        </div>

        <button
            type="submit"
            name="{if isset($editingAssignment)}updateAssignment{else}submitAssignment{/if}"
            class="btn btn-primary">

            {if isset($editingAssignment)}
                Update Assignment
            {else}
                Assign Badge
            {/if}

        </button>

    </form>
</div>

 {include file="./badge-products.tpl"}
