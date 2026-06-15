<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductBadgeProduct extends ObjectModel
{
    public $id_product_badges_product;
    public $id_badge;
    public $id_product;
    public $date_add;
    public $date_upd;

    public static $definition = [
        'table' => 'product_badges_product',
        'primary' => 'id_product_badges_product',
        'fields' => [
            'id_badge' => [
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
                'required' => true,
            ],
            'id_product' => [
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedId',
                'required' => true,
            ],
            'date_add' => [
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
            ],
        ],
    ];


    public function add($autoDate = true, $nullValues = false)
    {
        $this->date_add = date('Y-m-d H:i:s');
        $this->date_upd = date('Y-m-d H:i:s');

        return parent::add($autoDate, $nullValues);
    }

    public function update($nullValues = false)
    {
        $this->date_upd = date('Y-m-d H:i:s');

        return parent::update($nullValues);
    }
}