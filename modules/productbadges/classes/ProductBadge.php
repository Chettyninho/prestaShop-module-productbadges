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
    public $days_threshold;
    public $stock_threshold;

    public $discount_value;
    public $discount_mode;

    public $start_date;
    public $end_date;

    public $auto_apply;
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

            'days_threshold' => [
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
            ],

            'stock_threshold' => [
                'type' => self::TYPE_INT,
                'validate' => 'isUnsignedInt',
            ],

            'discount_value' => [
                'type' => self::TYPE_FLOAT,
            ],

            'discount_mode' => [
                'type' => self::TYPE_STRING,
                'size' => 20,
            ],

            'start_date' => [
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
            ],

            'end_date' => [
                'type' => self::TYPE_DATE,
                'validate' => 'isDate',
            ],

            'auto_apply' => [
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