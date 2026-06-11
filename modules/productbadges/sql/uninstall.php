<?php

$sql = [];

$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'product_badges_product`';
$sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'product_badges`';

foreach ($sql as $query) {
    if (!Db::getInstance()->execute($query)) {
        return false;
    }
}

return true;