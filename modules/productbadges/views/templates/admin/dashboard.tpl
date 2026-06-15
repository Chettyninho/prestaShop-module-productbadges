<ul class="nav nav-tabs">
    <li class="{if $activeTab == 'dashboard'}active{/if}">
        <a href="{$currentUrl}&pb_tab=dashboard">Dashboard</a>
    </li>

    <li class="{if $activeTab == 'badges'}active{/if}">
        <a href="{$currentUrl}&pb_tab=badges">Manage Badges</a>
    </li>

</ul>

{if $activeTab == 'dashboard'}
    {include file="./tabs/mainDashboard.tpl"}
{/if}

{if $activeTab == 'badges'}
    {include file="./tabs/newBadge.tpl"}
{/if}






