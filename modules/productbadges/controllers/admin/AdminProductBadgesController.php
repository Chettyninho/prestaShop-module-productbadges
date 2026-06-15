<?php
require_once dirname(__FILE__) . '/../../classes/ProductBadgeProduct.php';
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__) . '/../../classes/ProductBadge.php';

class AdminProductBadgesController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = 'product_badges';
        $this->className = 'ProductBadge';
        $this->identifier = 'id_badge';
        $this->bootstrap = true;
        $this->lang = false;

        parent::__construct();

        $this->fields_list = [
            'id_badge' => [
                'title' => 'ID',
                'align' => 'center',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => $this->l('Internal name'),
            ],
            'label' => [
                'title' => $this->l('Label'),
            ],
            'type' => [
                'title' => $this->l('Type'),
            ],
            'color' => [
                'title' => $this->l('Color'),
            ],
            'active' => [
                'title' => $this->l('Active'),
                'active' => 'status',
                'type' => 'bool',
                'align' => 'center',
            ],
            'date_add' => [
                'title' => $this->l('Created'),
                'type' => 'datetime',
            ],
        ];



        $this->addRowAction('edit');
        $this->addRowAction('delete');
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Badge'),
                'icon'  => 'icon-tags',
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Internal name'),
                    'name' => 'name',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Visible label'),
                    'name' => 'label',
                    'required' => true,
                ],
                [
                    'type' => 'select',
                    'label' => $this->l('Type'),
                    'name' => 'type',
                    'required' => true,
                    'options' => [
                        'query' => [
                            [
                                'id' => 'manual',
                                'name' => 'Manual',
                            ],
                            [
                                'id' => 'new',
                                'name' => 'New product',
                            ],
                            [
                                'id' => 'low_stock',
                                'name' => 'Low stock',
                            ],
                            [
                                'id' => 'discount',
                                'name' => 'Discount',
                            ],
                            [
                                'id' => 'limited_time',
                                'name' => 'Limited time',
                            ],
                        ],
                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],
                [
                    'type' => 'color',
                    'label' => $this->l('Color'),
                    'name' => 'color',
                ],
                [
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'values' => [
                        [
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ],
                        [
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('No'),
                        ],
                    ],
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
            ],
        ];

        return parent::renderForm();
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();

        $this->page_header_toolbar_btn['dashboard'] = [
            'href' => $this->context->link->getAdminLink('AdminModules')
                . '&configure=productbadges',
            'desc' => $this->l('Back to dashboard'),
            'icon' => 'process-icon-back',
        ];

        $this->page_header_toolbar_btn['new_badge'] = [
            'href' => $this->context->link->getAdminLink('AdminProductBadges')
                . '&addproduct_badges',
            'desc' => $this->l('Add new badge'),
            'icon' => 'process-icon-new',
        ];
    }
    
}