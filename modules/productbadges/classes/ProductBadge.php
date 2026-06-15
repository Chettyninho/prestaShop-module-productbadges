<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductBadge extends ObjectModel
{
    public $name;
    public $label;
    public $type;
    public $color;
    public $active;
    public $date_add;
    public $date_upd;

    public static $definition = [
        'table' => 'product_badges',
        'primary' => 'id_badge',
        'fields' => [
            'name' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'size' => 255,
            ],
            'label' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'size' => 255,
            ],
            'type' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'size' => 50,
            ],
            'color' => [
                'type' => self::TYPE_STRING,
                'size' => 20,
            ],
            'active' => [
                'type' => self::TYPE_BOOL,
                'validate' => 'isBool',
            ],
            'date_add' => [
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
            ],
            'date_upd' => [
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