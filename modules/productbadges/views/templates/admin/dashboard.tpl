<ul class="nav nav-tabs">
    <li class="active">
        <a href="{$mainDashboardUrl}" >
            Dashboard
        </a>
    </li>

    <li>
        <a href="{$badgesUrl}" >
            Manage Badges
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="panel">
        <div id="dashboard" class="tab-panel active">
            <div class="stats_container" style>
                {include file="./stats.tpl"}
            </div>
            {include file="./badges-table.tpl"}
        </div>
    </div>
</div>





