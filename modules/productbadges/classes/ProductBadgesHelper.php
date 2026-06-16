<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__) . '/ProductBadge.php';
require_once dirname(__FILE__) . '/ProductBadgeProduct.php';

/**
 * Helper class para operaciones comunes con badges
 */
class ProductBadgesHelper
{
    /**
     * Asigna múltiples badges a un producto
     * @param int $idProduct ID del producto
     * @param array $badgeIds Array de IDs de badges
     * @return bool
     */
    public static function assignBadgesToProduct($idProduct, $badgeIds = [])
    {
        if (!is_array($badgeIds) || empty($badgeIds)) {
            return false;
        }

        $success = true;

        foreach ($badgeIds as $idBadge) {
            if (!ProductBadgeProduct::assignBadgeToProduct($idBadge, $idProduct)) {
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Reemplaza todos los badges de un producto
     * @param int $idProduct ID del producto
     * @param array $badgeIds Array de nuevos IDs de badges
     * @return bool
     */
    public static function replaceBadgesForProduct($idProduct, $badgeIds = [])
    {
        // Eliminar todas las asignaciones actuales
        Db::getInstance()->delete(
            'product_badges_product',
            'id_product = '.(int)$idProduct
        );

        // Asignar los nuevos badges
        if (!empty($badgeIds) && is_array($badgeIds)) {
            return self::assignBadgesToProduct($idProduct, $badgeIds);
        }

        return true;
    }

    /**
     * Obtiene todos los badges de un producto en formato HTML
     * @param int $idProduct ID del producto
     * @param string $htmlClass Clase CSS para el contenedor
     * @return string HTML de los badges
     */
    public static function getBadgesHtml($idProduct, $htmlClass = 'product-badges')
    {
        $badges = ProductBadgeProduct::getBadgesByProduct($idProduct, true);

        if (empty($badges)) {
            return '';
        }

        $html = '<div class="'.$htmlClass.'">';

        foreach ($badges as $badge) {
            $html .= '<span class="badge-item" style="background-color: '.$badge['color'].'; '
                    .'padding: 5px 10px; border-radius: 3px; color: white; font-weight: bold; '
                    .'display: inline-block; margin-right: 5px; font-size: 12px;" '
                    .'title="'.$badge['label'].'">'
                    .$badge['label']
                    .'</span>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Exporta todas las asignaciones a CSV
     * @param string $filepath Ruta del archivo CSV
     * @return bool
     */
    public static function exportAssignmentsToCSV($filepath)
    {
        $file = fopen($filepath, 'w');

        if (!$file) {
            return false;
        }

        // Header
        fputcsv($file, [
            'Badge ID',
            'Badge Name',
            'Badge Label',
            'Badge Type',
            'Badge Color',
            'Product ID',
            'Product Name',
            'Assigned Date'
        ]);

        // Data
        $assignments = ProductBadgeProduct::getAllAssignments(10000, 0);

        foreach ($assignments as $assignment) {
            fputcsv($file, [
                $assignment['id_badge'],
                $assignment['badge_name'],
                $assignment['badge_label'],
                $assignment['type'],
                $assignment['color'],
                $assignment['id_product'],
                $assignment['product_name'],
                $assignment['date_add']
            ]);
        }

        fclose($file);

        return true;
    }

    /**
     * Obtiene estadísticas de badges
     * @return array
     */
    public static function getStatistics()
    {
        $totalBadges = (int)Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM '._DB_PREFIX_.'product_badges'
        );

        $activeBadges = (int)Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM '._DB_PREFIX_.'product_badges WHERE active = 1'
        );

        $totalAssignments = ProductBadgeProduct::countAssignments();

        $productsWithBadges = (int)Db::getInstance()->getValue(
            'SELECT COUNT(DISTINCT id_product) FROM '._DB_PREFIX_.'product_badges_product'
        );

        $badgesDistribution = Db::getInstance()->executeS(
            'SELECT pb.name, COUNT(pbp.id_product_badges_product) as count
            FROM '._DB_PREFIX_.'product_badges pb
            LEFT JOIN '._DB_PREFIX_.'product_badges_product pbp
                ON pb.id_badge = pbp.id_badge
            GROUP BY pb.id_badge
            ORDER BY count DESC'
        );

        return [
            'total_badges' => $totalBadges,
            'active_badges' => $activeBadges,
            'inactive_badges' => $totalBadges - $activeBadges,
            'total_assignments' => $totalAssignments,
            'products_with_badges' => $productsWithBadges,
            'badges_distribution' => $badgesDistribution,
        ];
    }

    /**
     * Valida si una badge existe y está activa
     * @param int $idBadge ID de la badge
     * @return bool
     */
    public static function badgeExists($idBadge)
    {
        try {
            $badge = new ProductBadge($idBadge);
            return isset($badge->id) && (int)$badge->id === (int)$idBadge;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Obtiene información detallada de una badge
     * @param int $idBadge ID de la badge
     * @return array|null
     */
    public static function getBadgeInfo($idBadge)
    {
        $badge = Db::getInstance()->getRow(
            'SELECT * FROM '._DB_PREFIX_.'product_badges WHERE id_badge = '.(int)$idBadge
        );

        if ($badge) {
            $badge['products_count'] = ProductBadgeProduct::countProducts($idBadge);
        }

        return $badge;
    }
}
