<?php
//set page headers
$page_title = "Admin - Qtr Report";
include 'layout_header.php';
include_once 'config/database.php';
include_once 'objects/reportoptions.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

//pass connection to Report class
$product = new Report($db);

//call read method in Report class
$stmt = $product->read();
?>

<!--sidebar checkboxes-->
<div class="row">
    <div class="col-sm-3 ">
        <p class="h3"><strong>Select Reports to Include:</strong></p>
        <form>
            <?php
            //loop through and create checkbox options
            while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_category);
                echo " <label style='font-size:12px;'>
                                        <input type='checkbox' name='rec-type' value='main' id='$report_id'/> $report_title</label>
                                     <br>";
            }
            ?>
        </form>
    </div>

    <!--display of sample reports-->
    <div class="col-sm-9 border_separator_left">
        <div class="text_jpeg_group">
            <div class="row">
                <div class="col-md-4">
                    <div class="in-middle">
                        <h1 style="text-align: right;">Fully Automated Dashboard</h1>
                        <p style="text-align: right;">Utilizing your data, dashboard updates based on your timing to provide real-time trends and results.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="images/smashedpotatoes.jpg" style="width:100%;">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// footer
include_once "layout_footer.php";
?>