<div class="panel">
    <h3>Assign Badge</h3>

    <form method="post">

        <div class="form-group">
            <label>Badge</label>

            <select
                name="id_product_badge"
                class="form-control"
                required
            >
                <option value="">Select badge</option>

                {foreach $badgeOptions as $badge}
                    <option value="{$badge.id_badge}">
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
                    <option value="{$product.id_product}">
                        {$product.name}
                    </option>
                {/foreach}

            </select>
        </div>

        <button
            type="submit"
            name="submitAssignment"
            class="btn btn-primary"
        >
            Assign Badge
        </button>

    </form>
</div>

 {include file="./badge-products.tpl"}
