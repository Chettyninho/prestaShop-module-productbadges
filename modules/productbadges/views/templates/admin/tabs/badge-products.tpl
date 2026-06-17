<div class="panel">
    <h3>
        <i class="icon-tags"></i>
        Assigned Products
    </h3>

    <div class="table-responsive-row clearfix">
        <table class="table">
            <thead>
                <tr class="nodrag nodrop">
                    <th>
                        <strong><span class="title_box">Product</span></strong>
                    </th>
                    <th>
                        <strong><span class="title_box">Badge</span></strong>
                    </th>
                    <th width="120">
                        <strong><span class="title_box">Type</span></strong>
                    </th>
                    <th width="180">
                        <strong><span class="title_box">Assigned</span></strong>
                    </th>
                    <th width="140" class="text-right">
                        <strong><span class="title_box">Actions</span></strong>
                    </th>
                </tr>
            </thead>

            <tbody>
                {foreach $assignments as $assignment}
                    <tr>

                        <td>
                            {$assignment.product_name}
                        </td>

                        <td>
                            <span class="label label-primary">
                                {$assignment.badge_name}
                            </span>
                        </td>

                        <td>
                            {if $assignment.badge_type == 'manual'}
                                <span class="label label-default">
                                    Manual
                                </span>
                            {else}
                                <span class="label label-success">
                                    {$assignment.badge_type}
                                </span>
                            {/if}
                        </td>

                        <td>
                            {$assignment.date_add}
                        </td>

                        <td class="text-right">
                            <a href="{$editBadgeBaseUrl}&editAssignment={$assignment.id_product_badges_product}"
                               class="btn btn-default">
                                <i class="icon-pencil"></i>
                            </a>

                            <a href="{$editBadgeBaseUrl}&deleteAssignment={$assignment.id_product_badges_product}"
                               class="btn btn-danger">
                                <i class="icon-trash"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}

                {if empty($assignments)}
                    <tr>
                        <td colspan="6" class="text-center">
                            <em>No assignments found.</em>
                        </td>
                    </tr>
                {/if}
            </tbody>
        </table>
    </div>
</div>