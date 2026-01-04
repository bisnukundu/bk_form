<h1>Edit Contact Id: <?php echo $get_contact_id; ?></h1>

<pre>
    <?php
    print_r($contact);
    ?>
</pre>


<form method="POST">
    <?php wp_nonce_field('edit_bk_contact_' . $contact->id, 'edit_bk_contact') ?>

    <input type="hidden" value="<?php echo $contact->id;?>" name="contact_id">

    <label for="name">Name: </label>
    <input type="text" name="name" value="<?php echo esc_attr($contact->name); ?>">
    <br>
    <br>
    <label for="email">Email: </label>
    <input type="email" name="email" value="<?php echo esc_attr($contact->email); ?>">
    <br>
    <br>
    <label for="subject">Subject: </label>
    <input type="text" name="subject" value="<?php echo esc_attr($contact->subject); ?>">
    <br>
    <br>
    <label for="message">Message: </label>
    <textarea name="message"> <?php echo esc_textarea($contact->message) ?> </textarea>
    <?php echo submit_button("Update Contact", 'primary', 'update_contact') ?>
</form>

<a class="button btn-primary" href="<?php echo add_query_arg(['page' => 'bk-contacts'], admin_url('admin.php')); ?>">Back To Contact List</a>