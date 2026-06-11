<?php

class ProductBadge extends ObjectModel
{
    public $name;
    public $badge_type;
    public $label;
    public $color;
    public $active;

    public static $definition = [
        'table' => 'product_badges',
        'primary' => 'id_badge',
        'fields' => [
            'name' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'size' => 255
            ],
            'badge_type' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'size' => 50
            ],
            'label' => [
                'type' => self::TYPE_STRING,
                'required' => true,
                'size' => 255
            ],
            'color' => [
                'type' => self::TYPE_STRING,
                'size' => 20
            ],
            'active' => [
                'type' => self::TYPE_BOOL
            ],
        ]
    ];
}