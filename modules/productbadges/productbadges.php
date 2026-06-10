<?php

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
        return parent::install()
            && $this->registerHook('displayProductListFunctionalButtons')
            && $this->registerHook('displayHeader');
    }

    public function uninstall()
    {
        return parent::uninstall()
            && Configuration::deleteByName('PRODUCTBADGES_TEXT');
    }

    // =========================
    // BACK OFFICE CONFIG
    // =========================
    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            $text = Tools::getValue('PRODUCTBADGES_TEXT');

            if (!$text) {
                $output .= $this->displayError($this->l('Badge text required.'));
            } else {
                Configuration::updateValue('PRODUCTBADGES_TEXT', $text);
                $output .= $this->displayConfirmation($this->l('Saved successfully.'));
            }
        }

        return $output . $this->renderForm();
    }

    protected function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs'
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Badge text'),
                        'name' => 'PRODUCTBADGES_TEXT',
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-primary pull-right'
                ]
            ]
        ];

        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = (int) Configuration::get('PS_LANG_DEFAULT');

        $helper->submit_action = 'submit' . $this->name;

        $helper->fields_value['PRODUCTBADGES_TEXT'] = Configuration::get('PRODUCTBADGES_TEXT');

        return $helper->generateForm([$fields_form]);
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

    // =========================
    // BADGE EN PRODUCT LIST
    // =========================
    public function hookDisplayProductListFunctionalButtons($params)
    {
        $text = Configuration::get('PRODUCTBADGES_TEXT');

        if (!$text) {
            return '';
        }

        return '
            <span class="product-badge">
                ' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '
            </span>
        ';
    }
}