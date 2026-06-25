<?php

$sql = [];

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'product_badges` (
    `id_badge` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `label` VARCHAR(255) NOT NULL,
    `type` VARCHAR(50) NOT NULL DEFAULT \'manual\',
    `color` VARCHAR(20) DEFAULT \'#f27536\',
    `active` TINYINT(1) NOT NULL DEFAULT 1,
    `days_threshold` INT NULL,
    `stock_threshold` INT NULL,

    `discount_value` DECIMAL(10,2) NULL,
    `discount_mode` VARCHAR(20) NULL,

    `start_date` DATE NULL,
    `end_date` DATE NULL,

    `auto_apply` TINYINT(1) DEFAULT 0,
    `date_add` DATETIME NOT NULL,
    `date_upd` DATETIME NOT NULL,

    PRIMARY KEY (`id_badge`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4;';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'product_badges_product` (
    `id_product_badges_product` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_product_badge` INT UNSIGNED NOT NULL,
    `id_product` INT UNSIGNED NOT NULL,
    `date_add` DATETIME NOT NULL,
    `date_upd` DATETIME NOT NULL,
    `id_specific_price` INT UNSIGNED NULL,

    PRIMARY KEY (`id_product_badges_product`),
    UNIQUE KEY `unique_relation` (`id_product_badge`, `id_product`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4;';

foreach ($sql as $query) {
    if (!Db::getInstance()->execute($query)) {
        return false;
    }
}

return true;