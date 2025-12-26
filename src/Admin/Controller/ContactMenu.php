<?php

namespace BkForm\Admin\Controller;

use BkForm\Admin\Controller\ContactsList;

class ContactMenu
{

    function __construct()
    {
        add_action("admin_menu", [$this, 'create_menu']);
    }

    function view()
    {


        $contactTable = new ContactsList();

        $contactTable->prepare_items();

        echo "<form method='GET'>";
        echo "<input type='hidden' name='page' value='" . $_REQUEST['page'] . "' /?>";
        $contactTable->search_box("Contact Search", "contact_search");
        $contactTable->display();
        echo "</form>";
    }

    function create_menu()
    {
        add_menu_page("Contacts", "Contacts", 'manage_options', 'bk-contacts', [$this, 'view'], 'dashicons-email-alt', 3);
    }
}
