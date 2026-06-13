
<br><table class="table" id="product-badges-relation">
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
        {foreach $badges as $badge}
            <tr>
                <td><h4></h4></td>
                <td><h4></h4></td>
                <td><h4></h4></td>
                <td><h4></h4></td>
                <td><h4></h4></td>
                <td>
                    <a href="{$editBadgeBaseUrl}&editBadge={$badge.id_badge}"><button type="button" class="btn btn-primary">Edit</button></a>
                    <a href="{$editBadgeBaseUrl}&deleteBadge={$badge.id_badge}"><button type="button" class="btn btn-secondary">Delete</button></a>
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>