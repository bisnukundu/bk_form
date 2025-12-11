<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}
use BkForm\Core\Installer;

$installer = new Installer();
$installer->delete_table();


