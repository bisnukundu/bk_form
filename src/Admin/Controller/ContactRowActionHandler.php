<?php

function contact_delete($contact_id)
{
    global $wpdb;

    $table_name = BK_CONTACT_TABLE_NAME;

    $contact_deleted = $wpdb->delete(
        $table_name,
        array(
            'id' => $contact_id,
        ),
        array('%d')
    );
    return $contact_deleted;
}


function contact_update($contact_id) {}
function contact_view($contact_id) {}



