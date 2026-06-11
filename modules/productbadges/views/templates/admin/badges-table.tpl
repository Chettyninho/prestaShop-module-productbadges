<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Color</th>
            <th>Active</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        {foreach $badges as $badge}
            <tr>
                <td>{$badge.name}</td>
                <td>{$badge.type}</td>
                <td>{$badge.color}</td>
                <td>{$badge.active}</td>
                <td>{$badge.date_add}</td>
            </tr>
        {/foreach}
    </tbody>
</table>