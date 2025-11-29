<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}


global $wpdb;
$table_name = $table_prifix . 'bk_contact_form';

$table = $wpdb->prefix . $table_name;

$sql = "DROP TABLE IF EXISTS $table";

$wpdb->query($sql);


