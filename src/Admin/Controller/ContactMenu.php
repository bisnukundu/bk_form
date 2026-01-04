<?php

namespace BkForm\Admin\Controller;

use BkForm\Admin\Controller\ContactsList;
use BkForm\Core\Helper;

// ContactTableList Row Action Handler Functions File included.
require_once(BK_FORM_PATH . 'src/Admin/Controller/ContactRowActionHandler.php');


class ContactMenu
{

    use Helper;
    function __construct()
    {
        add_action("admin_menu", [$this, 'create_menu']);
        add_action("admin_init", [$this, 'handle_actions']);
        add_action("admin_init", [$this, 'process_bulk_action']);
        add_action('admin_notices', [$this, 'show_admin_notices']);
        add_filter('query_vars', [$this, 'add_contact_slug_query_var']);
        add_action('init', [$this, 'add_contact_rewrite_rule']);
        add_action('template_redirect', [$this, 'view_contact_content']);
        add_action('admin_init', [$this, 'handle_edit_logic']);
    }

    // Single contact view details disply 
    function view_contact_content()
    {
        $contact_slug = get_query_var('view_contact_slug');
        global $bk_contact_data;
        global $wpdb;

        $slug_to_contact_name = str_replace('_', ' ', $contact_slug);



        $contact_table = $wpdb->prefix . 'bk_contact_form';

        $query_to_get_single_contact = "SELECT * FROM $contact_table WHERE name=%s LIMIT %d";

        // Fetching single row 
        $result = $wpdb->get_row($wpdb->prepare($query_to_get_single_contact, [sanitize_text_field(ucwords($slug_to_contact_name)), 1]), ARRAY_A);

        $bk_contact_data =  $result;

        if (!empty($contact_slug)) {
            global $bk_contact_data;

            include BK_FORM_PATH . '/src/Frontend/View/ViewSingleContact.php';
            exit;
        }
    }

    function add_contact_rewrite_rule()
    {
        // Add rewrite rule: match 'view-contact/anything/' and map it to the query var
        add_rewrite_rule(
            '^view-contact/([^/]+)/?$', // Regex pattern: matches 'view-contact/', captures slug, optional trailing slash
            'index.php?view_contact_slug=$matches[1]', // Query string to use internally
            'top' // Priority
        );
    }

    //Custom Slug Register 
    function add_contact_slug_query_var($vars)
    {
        $vars[] = 'view_contact_slug';
        return $vars;
    }

    public function handle_actions()
    {
        error_log("Running. Admin_init");
        // Check if we are on the correct page and have an action
        if (!isset($_GET['page']) || $_GET['page'] !== 'bk-contacts') {
            return;
        }

        // Security check
        if (!current_user_can('manage_options')) {
            return;
        }

        $action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
        $contact_id = isset($_REQUEST['contact_id']) ? absint($_REQUEST['contact_id']) : 0;

        if ($action && $contact_id) {
            switch ($action) {
                case "delete_contact":
                    $contact_delete_success = contact_delete($contact_id);
                    if ($contact_delete_success) {
                        $redirect_url = add_query_arg(
                            array(
                                'page' => 'bk-contacts',
                                'deleted' => 'true',
                            ),
                            admin_url('admin.php')
                        );
                        wp_redirect($redirect_url);
                    } else {
                        $redirect_url = add_query_arg(
                            array(
                                'page' => 'bk-contacts',
                                'error' => 'delete_failed'
                            ),
                            admin_url('admin.php'),
                        );
                        wp_redirect($redirect_url,);
                    }
                    exit;
            }
        }
    }

    public function show_admin_notices()
    {
        // Check for delete success message
        $this->successNotice("Contact deleted successfully.", 'deleted');
        // Check for delete error message (optional)
        $this->errorNotice("Error: Could not delete the contact", "error");


        //bulk deleting notice
        $deleted_row_count = isset($_REQUEST['bulk_deleted_count']) ? $_REQUEST['bulk_deleted_count'] : 0;
        $this->successNotice("$deleted_row_count Contacts Delete Successfully", 'bulk_deleted');
        $this->errorNotice("Error: Could not delete the contact", "bulk_delete_error");
    }

    // Bulk Actions Handler

    function process_bulk_action()
    {
        $current_action = false;

        if (isset($_REQUEST['action']) && -1 != $_REQUEST['action']) {
            $current_action = sanitize_text_field($_REQUEST['action']);
        } elseif (isset($_REQUEST['action2']) && -1 != $_REQUEST['action2']) {
            $current_action = sanitize_text_field($_REQUEST['action2']);
        }

        if ($current_action) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'bk_contact_form';
            $contact_ids = isset($_REQUEST['contact_ids']) ? array_map('intval', $_REQUEST['contact_ids']) : array();
            $query_placeholder = implode(", ", array_fill(0, count($contact_ids), '%d'));
            switch ($current_action) {
                case "delete_contact":
                    $delete_query = "DELETE FROM $table_name WHERE id IN ($query_placeholder)";
                    $prepare_query = $wpdb->prepare($delete_query, $contact_ids);
                    $result = $wpdb->query($prepare_query);
                    if ($result) {
                        $redirect = add_query_arg(
                            [
                                'bulk_deleted_count' => count($contact_ids),
                                'page' => $_REQUEST['page'],
                                'bulk_deleted' => 'true'
                            ],
                            admin_url('admin.php')
                        );
                    } else {
                        $redirect = add_query_arg(
                            array(
                                'bulk_delete_error' => 'true',
                                'page' => $_REQUEST['page']
                            ),
                            admin_url('admin.php')
                        );
                    }
                    wp_redirect($redirect);
                    exit;
                case "sent_mail_contact":
                    die("sent mail contact");
                    exit;
            }
        }
    }


    function view()
    {


        $contactTable = new ContactsList();

        $contactTable->prepare_items();
        echo "<div class='wrap'>";
        echo "<form method='GET'>";
        echo "<input type='hidden' name='page' value='" . esc_attr($_REQUEST['page']) . "' />";
        $contactTable->search_box("Contact Search", "contact_search");
        $contactTable->display();
        echo "</form>";
        echo "<div>";
    }



    function create_menu()
    {
        add_menu_page("Contacts", "Contacts", 'manage_options', 'bk-contacts', [$this, 'view'], 'dashicons-email-alt', 3);
        add_submenu_page(
            ' ', //Set empty to hide this menu from contact menus.
            'Edit Contact',
            'Edit Contact',
            'manage_options',
            'edit-bk-contact',
            [$this, 'edit_bk_contact']
        );
    }

    function handle_edit_logic()
    {
        global $wpdb;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_REQUEST['update_contact'])) {
            $contact_id = absint($_REQUEST['contact_id']);

            if (!wp_verify_nonce($_REQUEST['edit_bk_contact'], 'edit_bk_contact_' . $contact_id)) {
                wp_die("Security check faild");
                exit;
            }
            $table_name = BK_CONTACT_TABLE_NAME;
            //Sanitize input field;

            $name = sanitize_text_field($_REQUEST['name']);
            $message = sanitize_textarea_field($_REQUEST['message']);
            $subject = sanitize_text_field($_REQUEST['subject']);
            $email = sanitize_email($_REQUEST['email']);


            $contact_updated = $wpdb->update(
                $table_name,
                [
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'subject' => $subject,
                ],
                [
                    'id' => $contact_id
                ],
                [
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                ],
                [
                    '%d'
                ]
            );

            if ($contact_updated) {
                wp_redirect(add_query_arg(['page' => 'bk-contacts'], admin_url('admin.php')));
                return;
                exit;
            }
        }
    }

    function edit_bk_contact()
    {
        global $wpdb;
        $get_contact_id = absint($_REQUEST['contact_id']);
        $table_name = BK_CONTACT_TABLE_NAME;
        $contact_query = $wpdb->prepare("SELECT * FROM $table_name WHERE id=%d", $get_contact_id);

        $contact = $wpdb->get_row($contact_query);



        ob_start();
        include BK_FORM_PATH . 'src/Admin/View/EditContact.php';
        echo ob_get_clean();
    }
}
