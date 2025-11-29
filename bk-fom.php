<?php

/**
 * Plugin Name: Bk-Form
 * Version: 1.0.0
 * Description: This is simple contact form.
 * Author: Bisnu Kunu
 * Author URI: bisnukundu.netlify.app
 * 
 */

if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}

class Starter
{

    function __construct()
    {
        add_action("wp_enqueue_scripts", [$this, 'enqueue_scripts']);
        add_action('show_bk_form', [$this, 'show_bk_form_fn']);
        register_activation_hook(__FILE__, [$this, 'create_table']);

        add_action('wp_loaded', [$this, 'form_process']);
    }

    function enqueue_scripts()
    {
        wp_enqueue_script('tailwind-css-bk', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4', [], time());
    }

    function show_bk_form_fn()
    {
        include(plugin_dir_path(__FILE__) . '/template/form-markup.php');
    }

    function form_process()
    {

        if (isset($_POST['bk_form_submit_btn'])) {
            if (!wp_verify_nonce($_POST['bk_ct_form_nonce'], 'bk_contact_form')) {
                print "Sorry, Your nonce is invalid";
                exit;
            } else {
                $name = sanitize_text_field($_POST['name'] ?? '');
                $email = sanitize_email($_POST['email'] ?? '');
                $subject = sanitize_text_field($_POST['subject'] ?? '');
                $message = sanitize_textarea_field($_POST['message'] ?? '');

                $data_arr = array(
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message
                );

                global $wpdb;
                $table_prifix = $wpdb->prefix;
                $table_name = $table_prifix . 'bk_contact_form';
                $status_msg_arr = array();


                if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {

                    $contact_insert = $wpdb->insert($table_name, $data_arr);
                    array_push($status_msg_arr, ['bk_form_status' => $contact_insert ? "Success" : "Faild"]);
                } else {
                    array_push($status_msg_arr, ['bk_form_status' => "all field required"]);
                }


                $redirect_url = add_query_arg(
                    $status_msg_arr,
                    wp_get_referer()
                );
                wp_redirect($redirect_url);
                exit;
            }
        }
    }

    function create_table()
    {
        global $wpdb;

        $table_prifix = $wpdb->prefix;
        $table_name = $table_prifix . 'bk_contact_form';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
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
}


$starter = new Starter();

$starter->create_table();
