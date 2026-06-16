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

    /**
     * Obtiene todos los badges asignados a un producto específico
     * @param int $idProduct ID del producto
     * @param bool $active Solo badges activos
     * @return array Array de badges
     */
    public static function getBadgesByProduct($idProduct, $active = true)
    {
        $sql = 'SELECT pb.*, pbp.date_add as assigned_date
                FROM `'._DB_PREFIX_.'product_badges_product` pbp
                INNER JOIN `'._DB_PREFIX_.'product_badges` pb 
                    ON pbp.id_badge = pb.id_badge
                WHERE pbp.id_product = '.(int)$idProduct;

        if ($active) {
            $sql .= ' AND pb.active = 1';
        }

        $sql .= ' ORDER BY pb.name ASC';

        return Db::getInstance()->executeS($sql);
    }

    /**
     * Obtiene todos los productos asignados a una badge específica
     * @param int $idBadge ID de la badge
     * @return array Array de productos
     */
    public static function getProductsByBadge($idBadge)
    {
        $sql = 'SELECT p.id_product, pl.name, pbp.date_add as assigned_date
                FROM `'._DB_PREFIX_.'product_badges_product` pbp
                INNER JOIN `'._DB_PREFIX_.'product` p 
                    ON pbp.id_product = p.id_product
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
                    ON p.id_product = pl.id_product
                    AND pl.id_lang = '.(int)Context::getContext()->language->id.'
                WHERE pbp.id_badge = '.(int)$idBadge.'
                ORDER BY pl.name ASC';

        return Db::getInstance()->executeS($sql);
    }

    /**
     * Verifica si existe una relación entre una badge y un producto
     * @param int $idBadge ID de la badge
     * @param int $idProduct ID del producto
     * @return bool
     */
    public static function relationExists($idBadge, $idProduct)
    {
        $count = Db::getInstance()->getValue(
            'SELECT COUNT(*)
            FROM `'._DB_PREFIX_.'product_badges_product`
            WHERE id_badge = '.(int)$idBadge.'
            AND id_product = '.(int)$idProduct
        );

        return (bool)$count;
    }

    /**
     * Asigna una badge a un producto
     * @param int $idBadge ID de la badge
     * @param int $idProduct ID del producto
     * @return bool
     */
    public static function assignBadgeToProduct($idBadge, $idProduct)
    {
        if (self::relationExists($idBadge, $idProduct)) {
            return false;
        }

        $assignment = new self();
        $assignment->id_badge = (int)$idBadge;
        $assignment->id_product = (int)$idProduct;

        return $assignment->add();
    }

    /**
     * Desasigna una badge de un producto
     * @param int $idBadge ID de la badge
     * @param int $idProduct ID del producto
     * @return bool
     */
    public static function unassignBadgeFromProduct($idBadge, $idProduct)
    {
        return Db::getInstance()->delete(
            'product_badges_product',
            'id_badge = '.(int)$idBadge.' AND id_product = '.(int)$idProduct
        );
    }

    /**
     * Obtiene todas las asignaciones con detalles de badge y producto
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getAllAssignments($limit = 100, $offset = 0)
    {
        $sql = 'SELECT pbp.id_product_badges_product,
                       pb.id_badge, pb.name as badge_name, pb.label as badge_label, pb.type, pb.color,
                       p.id_product, pl.name as product_name,
                       pbp.date_add, pbp.date_upd
                FROM `'._DB_PREFIX_.'product_badges_product` pbp
                INNER JOIN `'._DB_PREFIX_.'product_badges` pb 
                    ON pbp.id_badge = pb.id_badge
                INNER JOIN `'._DB_PREFIX_.'product` p 
                    ON pbp.id_product = p.id_product
                LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
                    ON p.id_product = pl.id_product
                    AND pl.id_lang = '.(int)Context::getContext()->language->id.'
                ORDER BY pbp.date_add DESC
                LIMIT '.(int)$limit.' OFFSET '.(int)$offset;

        return Db::getInstance()->executeS($sql);
    }

    /**
     * Cuenta el total de asignaciones
     * @return int
     */
    public static function countAssignments()
    {
        return (int)Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM `'._DB_PREFIX_.'product_badges_product`'
        );
    }
}