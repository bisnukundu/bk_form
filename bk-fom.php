<?php

/**
 * Plugin Name: Bk-Form
 * Version: 1.0.0
 * Description: This is simple contact form. To use this form use this shortcode anywhere [bk_contact_form] in the page.
 * Author: Bisnu Kunu
 * Author URI: bisnukundu.netlify.app
 * 
 */

if (!defined('ABSPATH')) {
    die('We\'re sorry, but you can not directly access this file.');
}

if (!defined('BK_CONTACT_TABLE_NAME')) {
    global $wpdb;
    $tableName = $wpdb->prefix . "bk_contact_form";

    define("BK_CONTACT_TABLE_NAME", $tableName);
}

if (!defined('BK_FORM_PATH')) {
    define("BK_FORM_PATH", plugin_dir_path(__FILE__));
}

if (!defined('BK_FORM_URL')) {
    define("BK_FORM_URL", plugin_dir_url(__FILE__));
}
if (file_exists(BK_FORM_PATH . '/vendor/autoload.php')) {
    require_once((BK_FORM_PATH . 'vendor/autoload.php'));
} else {
    die("Autoload.php not found");
}

use BkForm\Admin\Controller\ContactMenu;
use BkForm\Admin\Controller\ContactsList;
use BkForm\Core\Installer;
use BkForm\Frontend\Controller\ContactForm;


register_activation_hook(__FILE__, function () {
    $installer = new Installer();
    $installer->create_table();



    // Add rewrite rule: match 'view-contact/anything/' and map it to the query var
    add_rewrite_rule(
        '^view-contact/([^/]+)/?$', // Regex pattern: matches 'view-contact/', captures slug, optional trailing slash
        'index.php?view_contact_slug=$matches[1]', // Query string to use internally
        'top' // Priority
    );

    flush_rewrite_rules(); // Refresh the parmalinks;

});

register_deactivation_hook(__FILE__, function () {

    // $installer = new Installer();
    // $installer->delete_table();
    flush_rewrite_rules();
});

class Starter
{

    function __construct()
    {
        add_action('init', [$this, 'init']);
    }

    function init()
    {
        add_action("wp_enqueue_scripts", [$this, 'enqueue_scripts']);
    }

    function enqueue_scripts()
    {
        wp_enqueue_script('tailwind-css-bk', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4', [], time());
    }
}


$starter = new Starter();



new ContactForm();

new ContactMenu();
