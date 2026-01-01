<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    global $bk_contact_data;
    $row = $bk_contact_data;
    ?>

    <h1>Contact details of <?php echo $row['name'] ?? '' ?></h1>

    <?php
    if (!empty($row)):
    ?>

        <table border="1" style="width: 100%; max-width: 800px; font-size: 16px; border-collapse: collapse;">
            <tr>
                <th style="padding: 15px; background-color: #f2f2f2;">ID</th>
                <td style="padding: 15px;"><?php echo esc_html($row['id']); ?></td>
            </tr>
            <tr>
                <th style="padding: 15px; background-color: #f2f2f2;">Name</th>
                <td style="padding: 15px;"><?php echo esc_html($row['name']); ?></td>
            </tr>
            <tr>
                <th style="padding: 15px; background-color: #f2f2f2;">Subject</th>
                <td style="padding: 15px;"><?php echo esc_html($row['subject']); ?></td>
            </tr>
            <tr>
                <th style="padding: 15px; background-color: #f2f2f2;">Email</th>
                <td style="padding: 15px;"><?php echo esc_html($row['email']); ?></td>
            </tr>
            <tr>
                <th style="padding: 15px; background-color: #f2f2f2;">Message</th>
                <td style="padding: 15px;"><?php echo esc_html($row['message']); ?></td>
            </tr>
            <tr>
                <th style="padding: 15px; background-color: #f2f2f2;">Created At</th>
                <td style="padding: 15px;"><?php echo esc_html($row['created_at']); ?></td>
            </tr>
        </table>
    <?php
    else:
        echo "Data Not Found";
    endif
    ?>

</body>

</html>