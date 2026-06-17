<?php
require_once __DIR__ . '/classes/ProductBadge.php';
require_once __DIR__ . '/classes/ProductBadgeProduct.php';

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
        $idTabAsign = (int) Tab::getIdFromClassName('AdminProductBadgesAsign');

        if ($idTab) {
            return true;
        }
        if ($idTabAsign) {
            return true;
        }
        

        $tab = new Tab();
        $tabAsign = new Tab();

        $tab->class_name = 'AdminProductBadges';
        $tabAsign->class_name = 'AdminProductBadges';
        $tab->module = $this->name;
        $tabAsign->module = $this->name;
        $tab->active = 1;
        $tabAsign->active = 1;
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminCatalog');
        $tabAsign->id_parent = (int) Tab::getIdFromClassName('AdminCatalog');

        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Product Badges';
            $tabAsign->name[$lang['id_lang']] = 'Product Badges Asign';
        }

        return $tab->add() && $tabAsign->add();
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
public function getContent()
{

    $showForm = false;
    $showButton = true;

    if (Tools::getValue('showForm')) {
        $showForm = true;
        $showButton = false;

    }
    // =================================
    // CREATE BADGE
    // =================================

    if (Tools::isSubmit('submitBadge')) {

        $idBadge = (int)Tools::getValue('id_badge');

        if ($idBadge) {
            $badge = new ProductBadge($idBadge);
        } else {
            $badge = new ProductBadge();
        }

        $badge->name = Tools::getValue('name');
        $badge->label = Tools::getValue('label');
        $badge->type = Tools::getValue('type');
        $badge->color = Tools::getValue('color');
        $badge->active = (int)Tools::getValue('active');

        if ($idBadge) {
            $badge->update();
        } else {
            $badge->add();
        }

        Tools::redirectAdmin(
            AdminController::$currentIndex
            .'&configure='.$this->name
            .'&pb_tab=badges'
            .'&token='.Tools::getAdminTokenLite('AdminModules')
        );
    }

    // =================================
    // CREATE ASSIGNMENT
    // =================================

    if (Tools::isSubmit('submitAssignment')) {

        $idBadge = (int) Tools::getValue('id_product_badge');
        $idProduct = (int) Tools::getValue('id_product');

        if ($idBadge && $idProduct) {
            if (ProductBadgeProduct::relationExists($idBadge, $idProduct)) {
                $this->context->controller->errors[] = $this->l('This assignment already exists.');
            } else {
                if (ProductBadgeProduct::assignBadgeToProduct($idBadge, $idProduct)) {
                    Tools::redirectAdmin(
                        AdminController::$currentIndex
                        . '&configure=' . $this->name
                        . '&pb_tab=dashboard'
                        . '&token=' . Tools::getAdminTokenLite('AdminModules')
                    );
                } else {
                    $this->context->controller->errors[] = $this->l('Error creating assignment.');
                }
            }
        }
    }

    // =================================
    // DELETE BADGE
    // =================================

    if (Tools::getValue('deleteBadge')) {

        $idBadge = (int) Tools::getValue('deleteBadge');

        Db::getInstance()->delete(
            'product_badges',
            'id_badge = '.$idBadge
        );
    }

    // =================================
    // DELETE ASSIGNMENT
    // =================================

    if (Tools::getValue('deleteAssignment')) {

        $idAssign = (int) Tools::getValue('deleteAssignment');

        Db::getInstance()->delete(
            'product_badges_product',
            'id_product_badges_product = '.(int)$idAssign
        );

        Tools::redirectAdmin(
            AdminController::$currentIndex
            . '&configure=' . $this->name
            . '&pb_tab=dashboard'
            . '&token=' . Tools::getAdminTokenLite('AdminModules')
        );
    }

    // =================================
    // EDIT ASSIGNMENT
    // =================================

    if (Tools::getValue('editAssignment')) {

        $idAssign = (int) Tools::getValue('editAssignment');

        $assignment = Db::getInstance()->getRow(
            'SELECT *
            FROM `'._DB_PREFIX_.'product_badges_product`
            WHERE id_product_badges_product = '.$idAssign
        );

        $this->context->smarty->assign([
            'editingAssignment' => $assignment,
        ]);

    }

    // =================================
    // UPDATE ASSIGNMENT
    // =================================

    if (Tools::isSubmit('updateAssignment')) {

        $idAssign = (int) Tools::getValue('id_assignment');

        Db::getInstance()->update(
            'product_badges_product',
            [
                'id_product_badge' => (int) Tools::getValue('id_product_badge'),
                'id_product' => (int) Tools::getValue('id_product'),
                'date_upd' => date('Y-m-d H:i:s'),
            ],
            'id_product_badges_product = '.$idAssign
        );

        Tools::redirectAdmin(
            AdminController::$currentIndex
            . '&configure=' . $this->name
            . '&pb_tab=dashboard'
            . '&token=' . Tools::getAdminTokenLite('AdminModules')
        );
    }

    // =================================
    // EDIT BADGE
    // =================================

    if (Tools::getValue('editBadge')) {

        $idBadge = (int) Tools::getValue('editBadge');

        $badge = Db::getInstance()->getRow(
            'SELECT *
            FROM `'._DB_PREFIX_.'product_badges`
            WHERE id_badge = '.$idBadge
        );

        $this->context->smarty->assign([
            'editingBadge' => $badge,
        ]);
        $showForm = true;
        $showButton = false;

    }

    // =================================
    // DASHBOARD DATA
    // =================================

    $totalBadges = (int) Db::getInstance()->getValue(
        'SELECT COUNT(*)
        FROM `'._DB_PREFIX_.'product_badges`'
    );

    $activeBadges = (int) Db::getInstance()->getValue(
        'SELECT COUNT(*)
        FROM `'._DB_PREFIX_.'product_badges`
        WHERE active = 1'
    );

    $inactiveBadges = $totalBadges - $activeBadges;

    // =================================
    // TAB
    // =================================

    $activeTab = Tools::getValue('pb_tab', 'dashboard');

    // =================================
    // BADGES
    // =================================

    $badges = Db::getInstance()->executeS(
        'SELECT
            id_badge,
            name,
            label,
            type,
            color,
            active,
            date_add
        FROM `'._DB_PREFIX_.'product_badges`
        ORDER BY date_add DESC'
    );

    // =================================
    // ASSIGNMENTS
    // =================================

    $assignments = Db::getInstance()->executeS(
        'SELECT
            pbp.id_product_badges_product,
            pb.id_badge,
            pb.name AS badge_name,
            pb.label AS badge_label,
            pb.type AS badge_type,
            pb.color,
            pl.name AS product_name,
            pbp.date_add
        FROM `'._DB_PREFIX_.'product_badges_product` pbp

        LEFT JOIN `'._DB_PREFIX_.'product_badges` pb
            ON pbp.id_product_badge = pb.id_badge

        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
            ON pbp.id_product = pl.id_product
            AND pl.id_lang = '.(int)$this->context->language->id.'

        ORDER BY pbp.date_add DESC'
    );

    // =================================
    // FORM OPTIONS
    // =================================

    $badgeOptions = Db::getInstance()->executeS(
        'SELECT
            id_badge,
            name
        FROM `'._DB_PREFIX_.'product_badges`
        ORDER BY name ASC'
    );

    $productOptions = Db::getInstance()->executeS(
        'SELECT
            p.id_product,
            pl.name
        FROM `'._DB_PREFIX_.'product` p

        LEFT JOIN `'._DB_PREFIX_.'product_lang` pl
            ON p.id_product = pl.id_product

        WHERE pl.id_lang = '.(int)$this->context->language->id.'
        AND pl.id_shop = '.(int)$this->context->shop->id.'

        ORDER BY pl.name ASC'
    );

    // =================================
    // SMARTY
    // =================================

    $this->context->smarty->assign([

        'totalBadges' => $totalBadges,
        'activeBadges' => $activeBadges,
        'inactiveBadges' => $inactiveBadges,

        'badges' => $badges,
        'assignments' => $assignments,

        'badgeOptions' => $badgeOptions,
        'productOptions' => $productOptions,

        'activeTab' => $activeTab,
        'showForm' => $showForm,
        'showButton' => $showButton,
        'currentUrl' => AdminController::$currentIndex
            . '&configure=' . $this->name
            . '&token=' . Tools::getAdminTokenLite('AdminModules'),

        'editBadgeBaseUrl' => AdminController::$currentIndex
        . '&configure=' . $this->name
        . '&token=' . Tools::getAdminTokenLite('AdminModules'),
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