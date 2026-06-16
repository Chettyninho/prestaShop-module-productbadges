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
                    Manual
                </option>

                <option value="new"
                    {if isset($editingBadge) && $editingBadge.type == 'new'}selected{/if}>
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
            <th><strong>Product ID</strong></th>
            <th><strong>Product Name</strong></th>
            <th><strong>Badge Name</strong></th>
            <th><strong>Badge Type</strong></th>
            <th><strong>Date</strong></th>
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