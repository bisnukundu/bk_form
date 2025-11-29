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
    }

    function enqueue_scripts()
    {
        wp_enqueue_script('tailwind-css-bk', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4', [], time());
    }

    function show_bk_form_fn()
    {
        include(plugin_dir_path(__FILE__) . '/template/form-markup.php');
        $this->form_process();
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

                echo '<pre>' . print_r(compact('name', 'email', 'subject', 'message'), true) . '</pre>';
            }
        }
    }

    function create_table() {}
}


new Starter();
