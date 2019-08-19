<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $page_title; ?></title>

        <!-- Latest compiled and minified Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

        <!-- our custom CSS -->
        <link rel="stylesheet" href="libs/css/custom.css" />

    </head>
    <body>

        <!-- container -->
        <div class="container">

            <?php
            include_once 'config/database.php';
            include_once 'objects/reportoptions.php';

            // get database connection
            $database = new Database();
            $db = $database->getConnection();

            //pass connection to Report class
            $product = new Report($db);

            //call read method in Report class
            $stmt = $product->read();

            //loop through and create checkbox options
            while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_category);
                echo "<option value='{$report_id}'>{$report_title}</option>";
            }


            ?>
        </div>
    </body>
</html>