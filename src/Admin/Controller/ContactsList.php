<?php

namespace BkForm\Admin\Controller;

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

use WP_List_Table;

class ContactsList extends WP_List_Table
{

    private $table_data;


    function get_columns()
    {
        $columns = array(
            'cb'    => "<input type='checkbox' />",
            'name' => __('Name'),
            'email' => __('Email'),
            'subject' => __('Subject'),

        );

        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name'  =>  array('name', true),
            'email' => array('email', false),
        );
        return $sortable_columns;
    }

    function prepare_items()
    {
        $this->table_data = $this->get_table_data();

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->items = $this->table_data;

        $this->_column_headers = array(
            $columns,
            $hidden,
            $sortable
        );
    }

    // our custom method for getting data form database table 
    function get_table_data()
    {
        global $wpdb;

        // These are getting form url peramiter for sorting.
        $order = !empty($_GET['order']) ? sanitize_text_field($_GET['order']) : 'asc';
        $orderBy = !empty($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'id';

        $table_name = $wpdb->prefix . 'bk_contact_form';
        $contactQuery = "SELECT * FROM $table_name ORDER BY $orderBy $order";
        $contactsData = $wpdb->get_results($contactQuery, ARRAY_A);
        return is_array($contactsData) ? $contactsData : [];
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    function column_email($item)
    {
        $modify_email = "<a href='mailto:" . sanitize_email($item['email']) . "'>" . $item["email"] . "</a>";
        return $modify_email;
    }


    function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="element[]" value="%s" />', $item['id']);
    }
}
