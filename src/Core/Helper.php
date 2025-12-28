<?php

namespace BkForm\Core;

trait Helper
{

    function successNotice($msg, $query_param_key_name)
    {
        // Check for success message
        if (isset($_GET[$query_param_key_name]) && $_GET[$query_param_key_name] === 'true') {
            echo '<div class="notice notice-success is-dismissible">';
            echo "<p>$msg</p>";
            echo '</div>';
        }
    }

    public function errorNotice($msg, $query_param_key_name)
    {
        // Check for error message (optional)
        if (isset($_GET[$query_param_key_name]) && $_GET[$query_param_key_name] === 'false') {
            echo '<div class="notice notice-error is-dismissible">';
            echo "<p>$msg</p>";
            echo '</div>';
        }
    }
}
