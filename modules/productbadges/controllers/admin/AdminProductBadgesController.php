<?php

class AdminProductBadgesController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = 'product_badges';
        $this->className = 'ProductBadge';
        $this->bootstrap = true;

        parent::__construct();

        $this->fields_list = [
            'id_badge' => [
                'title' => 'ID'
            ],
            'name' => [
                'title' => 'Name'
            ],
            'badge_type' => [
                'title' => 'Type'
            ],
            'active' => [
                'title' => 'Active',
                'active' => 'status',
                'type' => 'bool'
            ]
        ];
    }
}