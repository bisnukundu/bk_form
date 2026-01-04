<?php

namespace BkForm\Frontend\Controller;

class ContactForm
{
    function __construct()
    {
        add_action('show_bk_form', [$this, 'show_bk_form_fn_for_shortcode']);
        add_shortcode("bk_contact_form", [$this, 'show_bk_form_fn_for_shortcode']);
        add_action('wp_loaded', [$this, 'form_process']);
    }

    function show_bk_form_fn_for_shortcode()
    {



        ob_start();
        include(BK_FORM_PATH . '/src/Frontend/View/contactFormMarkup.php');
        return ob_get_clean();
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
                $table_name = BK_CONTACT_TABLE_NAME;
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
}
