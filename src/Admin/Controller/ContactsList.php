<?php

namespace BkForm\Admin\Controller;


class ContactsList
{

    function __construct()
    {
        add_action("admin_menu", [$this, 'create_menu']);
    }

    function view()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "bk_contact_form";
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query);

        ob_start();
        include(BK_FORM_PATH . '/src/Admin/View/ContactsList.php');
        echo ob_get_clean();
    }

    function create_menu()
    {
        add_menu_page("Contacts", "Contacts", 'manage_options', 'bk-contacts', [$this, 'view'], '', 3);
    }
}
