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
        $contactTable->display();
    }

    function create_menu()
    {
        add_menu_page("Contacts", "Contacts", 'manage_options', 'bk-contacts', [$this, 'view'], 'dashicons-email-alt', 3);
    }
}
