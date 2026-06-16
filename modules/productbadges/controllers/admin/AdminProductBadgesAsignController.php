<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductBadgeProduct extends ObjectModel
{
    public $id_product_badge;
    public $id_product;
    public $date_add;
    public $date_upd;

    public static $definition = [
        'table' => 'product_badges_product',
        'primary' => 'id_product_badges_product',
        'fields' => [
            'id_product_badge' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true],
            'id_product' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true],
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];
}

class AdminProductBadgesAsignController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'product_badges_product';
        $this->className = 'ProductBadgeProduct';
        $this->identifier = 'id_product_badges_product';
        $this->lang = false;
        $this->list_no_link = false;
        $this->allow_export = false;

        parent::__construct();

        $this->_select = 'pb.name AS badge_name, pl.name AS product_name';
        $this->_join = 'LEFT JOIN '._DB_PREFIX_.'product_badges pb
                            ON a.id_badge = pb.id_badge '
                            . 'LEFT JOIN '._DB_PREFIX_.'product_lang pl
                            ON a.id_product = pl.id_product
                            AND pl.id_lang = '.(int)$this->context->language->id.'
                            AND pl.id_shop = '.(int)$this->context->shop->id;

        $this->fields_list = [
            'id_product_badges_product' => ['title' => $this->l('ID'), 'align' => 'center', 'class' => 'fixed-width-xs'],
            'badge_name' => ['title' => $this->l('Badge'), 'filter_key' => 'pb!name'],
            'product_name' => ['title' => $this->l('Product'), 'filter_key' => 'pl!name'],
            'date_add' => ['title' => $this->l('Assigned'), 'type' => 'datetime'],
            'date_upd' => ['title' => $this->l('Modified'), 'type' => 'datetime'],
        ];

        $this->addRowAction('edit');
        $this->addRowAction('delete');
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Assign badge to product'),
                'icon' => 'icon-tag',
            ],
            'input' => [
                [
                    'type' => 'select',
                    'label' => $this->l('Badge'),
                    'name' => 'id_badge',
                    'required' => true,
                    'options' => [
                        'query' => $this->getBadgeOptions(),
                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],
                [
                    'type' => 'select',
                    'label' => $this->l('Product'),
                    'name' => 'id_product',
                    'required' => true,
                    'options' => [
                        'query' => $this->getProductOptions(),
                        'id' => 'id',
                        'name' => 'name',
                    ],
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
            ],
        ];

        $this->loadObject(true);

        return parent::renderForm();
    }

    protected function getBadgeOptions()
    {
        return Db::getInstance()->executeS('SELECT id_badge AS id, name FROM '._DB_PREFIX_.'product_badges');
    }

    protected function getProductOptions()
    {
        return Db::getInstance()->executeS(
            'SELECT p.id_product AS id, pl.name
             FROM '._DB_PREFIX_.'product p
             LEFT JOIN '._DB_PREFIX_.'product_lang pl ON p.id_product = pl.id_product
             WHERE pl.id_lang = '.(int) $this->context->language->id.' AND pl.id_shop = '.(int) $this->context->shop->id
        );
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submitAdd'.$this->table)) {
            $idBadge = (int) Tools::getValue('id_product_badge');
            $idProduct = (int) Tools::getValue('id_product');

            if ($idBadge && $idProduct) {
                $exists = Db::getInstance()->getValue(
                    'SELECT COUNT(*) FROM '._DB_PREFIX_.'product_badges_product
                     WHERE id_product_badge = '.(int) $idBadge.' AND id_product = '.(int) $idProduct
                );

                if ($exists) {
                    $this->errors[] = $this->l('Esta relación ya existe.');
                }
            }
        }

        parent::postProcess();
    }
}
