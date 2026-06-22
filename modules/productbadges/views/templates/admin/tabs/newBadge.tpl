<div class="panel">
    <h3>Create Badge</h3>

{if !$showForm}
<a href="{$editBadgeBaseUrl}&showForm=1&pb_tab=badges" class="btn btn-primary">
    New Badge
</a>
{/if}

{if $showForm}

<div class="panel">

    <h3>
        {if isset($editingBadge)}
            Edit Badge
        {else}
            Create Badge
        {/if}
    </h3>

    <form method="post">

        <input
            type="hidden"
            name="id_badge"
            value="{$editingBadge.id_badge|default:''}"
        >

        <div class="form-group">
            <label>Internal name</label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="{$editingBadge.name|default:''}"
                required
            >
        </div>

        <div class="form-group">
            <label>Visible label</label>

            <input
                type="text"
                name="label"
                class="form-control"
                value="{$editingBadge.label|default:''}"
                required
            >
        </div>

        <div class="form-group">
            <label>Type</label>

            <select
                name="type"
                class="form-control"
                required
            >
                <option value="manual"
                    {if isset($editingBadge) && $editingBadge.type == 'manual'}selected{/if}>
                    Custom
                </option>

                <option value="new_product"
                    {if isset($editingBadge) && $editingBadge.type == 'new_product'}selected{/if}>
                    New product
                </option>

                <option value="low_stock"
                    {if isset($editingBadge) && $editingBadge.type == 'low_stock'}selected{/if}>
                    Low stock
                </option>

                <option value="discount" 
                    {if isset($editingBadge) && $editingBadge.type == 'discount'}selected{/if}>
                    Discount
                </option>

                <option value="limited_time"
                    {if isset($editingBadge) && $editingBadge.type == 'limited_time'}selected{/if}>
                    Limited time
                </option>
            </select>
        </div>

            <!-- Selectores -->
            <div id="badge-config-new-product" class="badge-config-block">
        <div class="form-group">
            <label>Days since creation</label>

            <input
                type="number"
                name="days_threshold"
                class="form-control"
                min="1"
                value="{$editingBadge.days_threshold|default:'30'}"
            >
        </div>
    </div>

    <div id="badge-config-low-stock" class="badge-config-block">
        <div class="form-group">
            <label>Stock threshold</label>

            <input
                type="number"
                name="stock_threshold"
                class="form-control"
                min="1"
                value="{$editingBadge.stock_threshold|default:'5'}"
            >
        </div>
    </div>

    <div id="badge-config-discount" class="badge-config-block">

        <div class="form-group">
            <label>Discount mode</label>

            <select
                name="discount_mode"
                class="form-control"
            >
                <option value="percentage"
                    {if isset($editingBadge) && $editingBadge.discount_mode == 'percentage'}selected{/if}>
                    Percentage
                </option>

                <option value="fixed"
                    {if isset($editingBadge) && $editingBadge.discount_mode == 'fixed'}selected{/if}>
                    Fixed amount
                </option>
            </select>
        </div>

        <div class="form-group">
            <label>Discount value</label>

            <input
                type="number"
                name="discount_value"
                step="0.01"
                min="0"
                class="form-control"
                value="{$editingBadge.discount_value|default:''}"
            >
        </div>
    </div>

    <div id="badge-config-limited-time" class="badge-config-block">

        <div class="form-group">
            <label>Start date</label>

            <input
                type="date"
                name="start_date"
                class="form-control"
                value="{$editingBadge.start_date|default:''}"
            >
        </div>

        <div class="form-group">
            <label>End date</label>

            <input
                type="date"
                name="end_date"
                class="form-control"
                value="{$editingBadge.end_date|default:''}"
            >
        </div>
    </div>

        <div class="form-group">
            <label>Color</label>

            <input
                type="color"
                name="color"
                value="{$editingBadge.color|default:'#f27536'}"
                class="form-control"
            >
        </div>

        <div class="form-group">
            <label>Active</label>

            <select
                name="active"
                class="form-control"
            >
                <option value="1"
                    {if isset($editingBadge) && $editingBadge.active == 1}selected{/if}>
                    Yes
                </option>

                <option value="0"
                    {if isset($editingBadge) && $editingBadge.active == 0}selected{/if}>
                    No
                </option>
            </select>
        </div>

        <button
            type="submit"
            name="submitBadge"
            class="btn btn-primary"
        >
            {if isset($editingBadge)}
                Update Badge
            {else}
                Create Badge
            {/if}
        </button>

        <a
            href="{$editBadgeBaseUrl}&pb_tab=badges"
            class="btn btn-secondary"
        >
            Close
        </a>

    </form>

</div>

{/if}


<br>
<table class="table" id="product-badges-relation">
    <thead>
        <tr>
            <th><strong>Badge ID</strong></th>
            <th><strong>Badge Name</strong></th>
            <th><strong>Badge Type</strong></th>
            <th><strong>Color Badge</strong></th>
            <th><strong>Date</strong></th>
            <th><strong>State</strong></th>
            <th><strong>Action</strong></th>
        </tr>
    </thead>

    <tbody>
            {if $activeTab == 'assignments' || ($activeTab == 'dashboard' && $assignments)}
                {foreach $assignments as $assignment}
                    <tr>
                        <td><h4>{$assignment.id_product_badges_product}</h4></td>
                        <td><h4>{$assignment.product_name}</h4></td>
                        <td><h4>{$assignment.badge_name}</h4></td>
                        <td><h4>{$assignment.badge_type}</h4></td>
                        <td><h4>{$assignment.date_add}</h4></td>
                        <td>
                            <a href="{$editBadgeBaseUrl}&deleteAssignment={$assignment.id_product_badges_product}&pb_tab=assignments"><button type="button" class="btn btn-secondary">Delete</button></a>
                        </td>
                    </tr>
                {/foreach}
            {elseif $activeTab == 'badges' || ($activeTab == 'dashboard' && $badges)}
                {foreach $badges as $badge}
                    <tr>
                        <td><h4>{$badge.id_badge}</h4></td>
                        <td><h4>{$badge.name}</h4></td>
                        <td><h4>{$badge.type}</h4></td>
                        <td><h4 style="background:{$badge.color}; width:60px; height:20px; display:inline-block; border:1px solid #ccc;"></h4></td>
                        <td><h4>{$badge.date_add}</h4></td>
                        <td>
                            <a href="{$editBadgeBaseUrl}&toggleBadge={$badge.id_badge}&pb_tab=badges">

                                <div class="switch-button">

                                    <input
                                        type="checkbox"
                                        class="switch-button__checkbox"
                                        id="switch-label-{$badge.id_badge}"
                                        {if $badge.active}checked{/if}
                                        disabled
                                    >

                                    <label
                                        for="switch-label-{$badge.id_badge}"
                                        class="switch-button__label"
                                    ></label>

                                </div>

                            </a>
                        </td>
                        <td>
                            <a href="{$editBadgeBaseUrl}&editBadge={$badge.id_badge}&showForm=1&pb_tab=badges" class="btn btn-primary"> Edit</a>
                            <a href="{$editBadgeBaseUrl}&deleteBadge={$badge.id_badge}&pb_tab=badges"><button type="button" class="btn btn-secondary">Delete</button></a>
                        </td>
                    </tr>
                {/foreach}
            {else}
                <tr>
                    <td colspan="6"><em>No data available for this tab.</em></td>
                </tr>
            {/if}
    </tbody>
</table>
<style>
.badge-config-block {
    display: none;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const typeSelect = document.querySelector('select[name="type"]');

    if (!typeSelect) {
        return;
    }

    function updateBadgeConfig() {

        document.querySelectorAll('.badge-config-block').forEach(function(el) {
            el.style.display = 'none';
        });

        switch(typeSelect.value) {

            case 'new_product':
                document.getElementById('badge-config-new-product').style.display = 'block';
                break;

            case 'low_stock':
                document.getElementById('badge-config-low-stock').style.display = 'block';
                break;

            case 'discount':
                document.getElementById('badge-config-discount').style.display = 'block';
                break;

            case 'limited_time':
                document.getElementById('badge-config-limited-time').style.display = 'block';
                break;
        }
    }

    typeSelect.addEventListener('change', updateBadgeConfig);

    updateBadgeConfig();
});
</script>