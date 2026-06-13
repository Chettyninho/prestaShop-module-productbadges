<?php
require_once __DIR__ . '/classes/ProductBadge.php';

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductBadges extends Module
{
    public function __construct()
    {
        $this->name = 'productbadges';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Miguel Acedo';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product Badges');
        $this->description = $this->l('Adds badges to products in listing.');
        $this->ps_versions_compliancy = ['min' => '1.7.0.0', 'max' => _PS_VERSION_];
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        if (!include(dirname(__FILE__).'/sql/install.php')) {
            return false;
        }

        if (!$this->installTab()) {
            return false;
        }

        return $this->registerHook('displayProductListFunctionalButtons')
            && $this->registerHook('displayHeader');
    }

    public function installTab()
    {
        $idTab = (int) Tab::getIdFromClassName('AdminProductBadges');

        if ($idTab) {
            return true;
        }

        $tab = new Tab();

        $tab->class_name = 'AdminProductBadges';
        $tab->module = $this->name;
        $tab->active = 1;
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminCatalog');

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Product Badges';
        }

        return $tab->add();
    }

    public function uninstall()
    {
        if (!include(dirname(__FILE__).'/sql/uninstall.php')) {
            return false;
        }

        return $this->uninstallTab() &&  
            parent::uninstall();
    }

    public function uninstallTab()
    {
        $idTab = (int)Tab::getIdFromClassName('AdminProductBadges');

        if ($idTab) {
            $tab = new Tab($idTab);
            return $tab->delete();
        }

        return true;
    }

    // =========================
    // BACK OFFICE CONFIG
    // =========================
   public function getContent()
    {
        $totalBadges = (int) Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM `'._DB_PREFIX_.'product_badges`'
        );

        $activeBadges = (int) Db::getInstance()->getValue(
            'SELECT COUNT(*) FROM `'._DB_PREFIX_.'product_badges` WHERE active = 1'
        );

        $inactiveBadges = $totalBadges - $activeBadges;

        $badges = Db::getInstance()->executeS(
            'SELECT name, type, color, active, date_add
            FROM `'._DB_PREFIX_.'product_badges`
            ORDER BY date_add DESC'
        );

        $this->context->smarty->assign([
            'totalBadges' => $totalBadges,
            'activeBadges' => $activeBadges,
            'inactiveBadges' => $inactiveBadges,
            'badges' => $badges,
            'addBadgeUrl' => $this->context->link->getAdminLink('AdminProductBadges') . '&addproduct_badges',
        ]);

        return $this->display(
            __FILE__,
            'views/templates/admin/dashboard.tpl'
        );
    }

    // =========================
    // FRONT OFFICE CSS
    // =========================
    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet(
            'productbadges-css',
            'modules/' . $this->name . '/views/css/productbadge_admin.css',
            ['media' => 'all', 'priority' => 150]
        );
    }

}