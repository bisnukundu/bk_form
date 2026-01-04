<?php

namespace BkForm\Core;

class Installer
{

    protected $tableName;

    function __construct()
    {
        global $wpdb;
        $this->tableName = BK_CONTACT_TABLE_NAME;
    }

    function create_table()
    {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->tableName (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    subject VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    function delete_table()
    {
        global $wpdb;

        $sql = "DROP TABLE IF EXISTS $this->tableName";

        $wpdb->query($sql);
    }
}
