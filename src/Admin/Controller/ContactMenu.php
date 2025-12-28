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
        add_action('admin_notices', [$this, 'show_admin_notices']);
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
    }


    function view()
    {

        $contactTable = new ContactsList();

        $contactTable->prepare_items();
        echo "<form method='GET'>";
        echo "<input type='hidden' name='page' value='" . esc_attr($_REQUEST['page']) . "' />";
        $contactTable->search_box("Contact Search", "contact_search");
        $contactTable->display();
        echo "</form>";
    }



    function create_menu()
    {
        add_menu_page("Contacts", "Contacts", 'manage_options', 'bk-contacts', [$this, 'view'], 'dashicons-email-alt', 3);
    }
}
