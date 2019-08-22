<?php
//set page headers
$page_title = "Admin - Qtr Report";
include 'layout_header.php';
include_once 'config/database.php';
include_once 'objects/report_options.php';
include 'objects/summblob.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

//pass connection to Report class
$reportlist = new Report_list($db);
$reportdisplay = new Report_list($db);
$reportsummblob = new Summary_blob($db);
$summblob_post = new Summary_blob($db);

//call read method in Report class
$stmt_list = $reportlist->read_list();
$stmt_display = $reportdisplay->read_display();
$stmt_summblob = $reportsummblob->read_blobs();
?>


<div class="row top-spacer" >

    <!--sidebar checkboxes-->
    <div class="col-sm-3 ">
        <p class="h3"><strong>Select Reports to Include:</strong></p>
        <form>
            <?php
            //loop through and create checkbox options
            while ($row_list = $stmt_list->fetch(PDO::FETCH_ASSOC)) {
                extract($row_list);
                echo " <label style='font-size:12px;'>
                                        <input type='checkbox' name='rec-type' value='main' id='$report_id'/> $report_title</label>
                             <br>";
            }
            ?>
        </form>
    </div>

    <!--display of sample reports-->
    <div class="col-sm-9 border_separator_left">

        <?php
        //loop through and create checkbox options
        while ($row_display = $stmt_display->fetch(PDO::FETCH_ASSOC)) {
            extract($row_display);
            ?>
            <div class="text_jpeg_group border_separator_bottom">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="in-middle">
                            <h1 style="text-align: right;"><?php echo $report_title ?></h1>
                            <div style="text-align: right;"><?php echo $report_desc ?></div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <img src="<?php echo $report_imgpath ?>" style="width:100%;">
                    </div>
                </div>
                <div class="row">
                    <!--include modal if necessary-->
                    <div class="col-sm-12">
                        <?php
                        if ($report_modal == 1) {
                            echo "<div class='btn btn-danger pull-right' id='tgl_{$modal_name}'>{$modal_buttontext}</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        <?php } ?>


    </div>

    <!--modal includes-->
    <?php include 'modals/modal_summblob.php' ?>;
</div>

<script>
    $(document).on("click", "#tgl_modal_summblob", function (e) {
        $('#modal_summblob').modal('toggle');
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

</script>

</script>

<?php
include_once "layout_footer.php";
?>

