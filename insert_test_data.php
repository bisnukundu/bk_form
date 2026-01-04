<?php
// insert_test_data.php

// Make sure this file is only accessible in a development environment
// Or require that the user is logged in and has admin privileges
// if (!is_admin() || !current_user_can('manage_options')) {
//     wp_die('Access denied.');
// }

// Include WordPress
require_once('../../../wp-load.php'); // Adjust path as needed to reach wp-load.php from your plugin dir
require_once('../../../wp-config.php'); // Ensure config is loaded
require_once('../../../wp-includes/class-wpdb.php'); // Ensure db is loaded

global $wpdb;

// Add this function to your main plugin file or a utility class

// Add this function to your main plugin file or a utility class

function insert_test_data()
{
    global $wpdb;

    
    $table_name = BK_CONTACT_TABLE_NAME;

    // Sample data sets
    $names = [
        'Alice Johnson',
        'Bob Smith',
        'Charlie Brown',
        'Diana Prince',
        'Ethan Hunt',
        'Fiona Green',
        'George King',
        'Hannah Lee',
        'Ian Wright',
        'Julia Roberts',
        'Kevin Hart',
        'Luna Lovegood',
        'Michael Scott',
        'Nina Dobrev',
        'Oscar Wild',
        'Paul Walker',
        'Quinn Fabray',
        'Robert Downey',
        'Sarah Connor',
        'Thomas Wayne',
        'Uma Thurman',
        'Vincent Vega',
        'Wanda Maximoff',
        'Xavier Caine',
        'Yasmin Khan',
        'Zoe Saldana',
        'Adam Sandler',
        'Bella Swan',
        'Chris Evans',
        'Daisy Ridley',
        'Emma Watson',
        'Frank Underwood',
        'Grace Hopper',
        'Henry Cavill',
        'Iris West',
        'Jack Sparrow',
        'Kara Danvers',
        'Logan Howlett',
        'Mia Wallace',
        'Nick Fury',
        'Oliver Queen',
        'Pennywise Derry',
        'Quagmire Peter',
        'Ragnar Lothbrok',
        'Sansa Stark',
        'Tony Stark',
        'Ursula Kock',
        'Violet Baudelaire',
        'Walter White',
        'Xena Warrior',
        'Yennefer Vengerberg',
        'Zorro Escalante',
        'Anya Forger',
        'Beast Boy',
        'Catwoman Kyle'
    ];

    $emails = [
        'alice@example.com',
        'bob@example.com',
        'charlie@example.com',
        'diana@example.com',
        'ethan@example.com',
        'fiona@example.com',
        'george@example.com',
        'hannah@example.com',
        'ian@example.com',
        'julia@example.com',
        'kevin@example.com',
        'luna@example.com',
        'michael@example.com',
        'nina@example.com',
        'oscar@example.com',
        'paul@example.com',
        'quinn@example.com',
        'robert@example.com',
        'sarah@example.com',
        'thomas@example.com',
        'uma@example.com',
        'vincent@example.com',
        'wanda@example.com',
        'xavier@example.com',
        'yasmin@example.com',
        'zoe@example.com',
        'adam@example.com',
        'bella@example.com',
        'chris@example.com',
        'daisy@example.com',
        'emma@example.com',
        'frank@example.com',
        'grace@example.com',
        'henry@example.com',
        'iris@example.com',
        'jack@example.com',
        'kara@example.com',
        'logan@example.com',
        'mia@example.com',
        'nick@example.com',
        'oliver@example.com',
        'penny@example.com',
        'quagmire@example.com',
        'ragnar@example.com',
        'sansa@example.com',
        'tony@example.com',
        'ursula@example.com',
        'violet@example.com',
        'walter@example.com',
        'xena@example.com',
        'yennefer@example.com',
        'zorro@example.com',
        'anya@example.com',
        'beast@example.com',
        'catwoman@example.com'
    ];

    $subjects = [
        'Hello World',
        'Support Request',
        'Feature Suggestion',
        'Bug Report',
        'Feedback',
        'Meeting Request',
        'Project Update',
        'Question',
        'Compliment',
        'Complaint',
        'Order Inquiry',
        'Account Issue',
        'Password Reset',
        'Newsletter Signup',
        'Job Application',
        'Partnership Proposal',
        'Event Invitation',
        'Thank You',
        'Welcome',
        'Reminder',
        'New Product Launch',
        'Discount Offer',
        'Survey Request',
        'Newsletter Unsubscribe',
        'Account Verification',
        'Payment Confirmation',
        'Shipping Update',
        'Return Request',
        'Technical Support',
        'Feature Request',
        'System Maintenance',
        'Security Alert',
        'New Blog Post',
        'Webinar Invitation',
        'Conference Call',
        'Training Session',
        'Demo Request',
        'Pricing Inquiry',
        'Quote Request',
        'Contract Renewal',
        'Service Disruption',
        'Data Export',
        'API Integration',
        'Customization Request',
        'Training Material',
        'Best Practices',
        'User Guide',
        'FAQ Update',
        'Release Notes',
        'Changelog',
        'Terms of Service',
        'Privacy Policy',
        'Cookie Policy',
        'Refund Policy',
        'Cancellation Policy'
    ];

    $messages = [
        'This is a sample message for testing purposes.',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'Ut enim ad minim veniam, quis nostrud exercitation ullamco.',
        'Duis aute irure dolor in reprehenderit in voluptate velit esse.',
        'Excepteur sint occaecat cupidatat non proident, sunt in culpa.',
        'Qui officia deserunt mollit anim id est laborum.',
        'Suspendisse potenti. In hac habitasse platea dictumst.',
        'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.',
        'Phasellus viverra nulla ut metus scelerisque ante.',
        'Nullam posuere quam ut ligula ullamcorper elementum.',
        'Integer tincidunt cras neque purus, accumsan quis, porttitor vitae.',
        'Fusce vulputate eleifend sapien. Vestibulum purus quam, scelerisque ut.',
        'Mauris sollicitudin fermentum libero. Integer in mauris eu nibh euismod gravida.',
        'Duis lobortis massa imperdiet quam. Suspendisse potenti.',
        'Nunc interdum lacus sit amet orci. Nullam dictum felis eu pede.',
        'Sed libero. Aliquam erat volutpat. In congue.',
        'Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl.',
        'Ut volutpat consequat mauris. Donec orci lectus, aliquam ut, faucibus non.',
        'Etiam ut purus mattis mauris sodales aliquam. Curabitur nisi.',
        'Quisque malesuada placerat nisl. Nam ipsum risus, rutrum vitae, vestibulum eu.',
        'Sed lectus. Praesent elementum hendrerit tortor.',
        'Sed semper lorem at ligula. Vivamus sollicitudin nisi vel quam.',
        'Suspendisse potenti. Aenean vulputate eleifend tellus.',
        'Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac.',
        'Donec ut dolor. Morbi vel erat non mauris convallis vehicula.',
        'Nulla sit amet est. Praesent metus tellus, elementum eu, semper a.',
        'Aptent taciti sociosqu ad litora torquent per conubia nostra.',
        'In hac habitasse platea dictumst. Integer eu lacus.',
        'Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus.',
        'Etiam sit amet orci eget eros faucibus tincidunt.',
        'Duis leo. Sed fringilla mauris sit amet nibh.',
        'Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales.',
        'Auctor velit imperdiet tellus. Integer aliquam adipiscing lacus.',
        'Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus.',
        'Quisque purus sed magna dictum blandit. Donec mattis, nisi id.',
        'Euismod aliquam. Fusce fermentum odio nec arcu.',
        'Vivamus luctus eros aliquam convallis ultricies. Mauris ante arcu.',
        'Aliquet imperdiet. Sed vel lectus. Donec odio tempus molestie.',
        'At imperdiet non, ultricies non, molestie. Sed eleifend.',
        'Nulla ut imperdiet orci. Praesent mauris. Fusce nec tellus.',
        'Sed sodales. Nulla quis diam. Integer vitae libero.',
        'Ac neque. Duis bibendum. Morbi ut quam.',
        'Cursus faucibus. Ut non magna at mauris commodo condimentum.',
        'Nam suscipit, quam in vulputate dictum, dui felis ullamcorper dui.',
        'Vel imperdiet nisi lorem eget mauris. Phasellus a est.',
        'Phasellus magna. In hac habitasse platea dictumst.',
        'Suspendisse egestas nisi vitae diam. Praesent mauris ante.',
        'Elementum ac, aliquam eu, tellus. Etiam neque.',
        'Integer eget enim. Duis dignissim tempor mauris.'
    ];

    $count = 0;
    $batch_size = 100; // Insert in batches to avoid memory issues
    $total_records = 500;

    // --- CHECK YOUR ACTUAL TABLE COLUMNS ---
    // Replace the column names in the array below with the EXACT names from your table.
    // Example: If your table has 'name', 'email', 'subject', 'message', 'status', remove 'date_submitted'.
    $table_columns = array('name', 'email', 'subject', 'message'); // Adjust these names!

    while ($count < $total_records) {
        $data_to_insert = array();

        for ($i = 0; $i < $batch_size && $count < $total_records; $i++, $count++) {
            $random_name = $names[array_rand($names)];
            $random_email = $emails[array_rand($emails)];
            $random_subject = $subjects[array_rand($subjects)];
            $random_message = $messages[array_rand($messages)];
            // $date_submitted = gmdate('Y-m-d H:i:s', strtotime("-" . rand(1, 365) . " days")); // Comment out date_submitted if not in table

            // --- BUILD THE ROW DATA ARRAY ---
            // Only include columns that actually exist in your table
            $row_data = array(
                'name' => $random_name,
                'email' => $random_email,
                'subject' => $random_subject,
                'message' => $random_message,
                // 'date_submitted' => $date_submitted, // Remove this line if column doesn't exist
            );

            $data_to_insert[] = $row_data;
        }

        // Prepare the INSERT query - Use the correct column names
        $columns = $table_columns; // Use the list of columns you defined above
        $placeholders = array_fill(0, count($columns), '%s');
        $placeholder_string = '(' . implode(',', $placeholders) . ')';

        $query = "INSERT INTO $table_name (" . implode(',', $columns) . ") VALUES ";
        $query .= implode(',', array_fill(0, count($data_to_insert), $placeholder_string));

        // Flatten the data array for prepare
        $flat_data = array();
        foreach ($data_to_insert as $row) {
            foreach ($columns as $col) { // Iterate through the defined columns
                $flat_data[] = $row[$col]; // Add the value for each defined column
            }
        }

        // Execute the query
        $result = $wpdb->query($wpdb->prepare($query, $flat_data));

        if ($result === false) {
            error_log("Failed to insert batch starting at count $count. Error: " . $wpdb->last_error);
            // Optionally break the loop on error
            // break;
        } else {
            error_log("Inserted batch of " . count($data_to_insert) . " records (Total so far: $count)");
        }
    }

    if ($count >= $total_records) {
        error_log("Successfully inserted $total_records test records into $table_name.");
    }
}

// --- CALL THE FUNCTION TO INSERT DATA ---
// Only run this once! Comment out or remove after running.
// insert_test_data();
// --- CALL THE FUNCTION TO INSERT DATA ---
// Only run this once! Comment out or remove after running.
// insert_test_data();
// Call the function
insert_test_data();

echo "Test data insertion completed. Check your debug.log or database.";
