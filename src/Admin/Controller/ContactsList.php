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
        $table_name = $wpdb->prefix . 'bk_contact_form';

        //Pagination Start     
        // Calculate pagination details
        $per_page = $this->get_items_per_page('contacts_per_page', 20);
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        // Count total items first (for pagination calculation)
        $total_items_query = "SELECT COUNT(*) FROM $table_name";
        $total_items = $wpdb->get_var($total_items_query);
        //Pagination End

        //Order Start
        // These are getting form url peramiter for sorting.
        $order = !empty($_GET['order']) ? sanitize_text_field($_GET['order']) : 'asc';
        $orderBy = !empty($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'id';
        //Order End


        $contactQuery = "SELECT * FROM $table_name ORDER BY $orderBy $order LIMIT %d OFFSET %d";
        $contactsData = $wpdb->get_results($wpdb->prepare($contactQuery, $per_page, $offset), ARRAY_A);

        $this->set_pagination_args(array(
            'total_items' => $total_items, // The total number of items
            'per_page'    => $per_page,    // The number of items per page
            'total_pages' => ceil($total_items / $per_page) // Calculate total pages
        ));

        return is_array($contactsData) ? $contactsData : [];
    }

    function column_default($item, $column_name)
    {
        return esc_html($item[$column_name]);
    }

    function column_name($item)
    {
        $contact_id = $item['id'];
        $actions = array(
            // 'action_slug' => 'HTML Link'
            "edit"  => sprintf(
                "<a href='%s'>EDIT</a>",
                esc_url(add_query_arg(array('action' => 'edit_contact', 'contact_id' => $contact_id))),
            ),
            'delete' => sprintf(
                "<a href='%s'>Delete</a>",
                esc_url(add_query_arg(array('action' => 'delete_contact', 'contact_id' => $contact_id))),
            ),
        );

        return esc_html($item['name']) . $this->row_actions($actions);
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
