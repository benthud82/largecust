<div id="modal_summblob" class="modal fade " role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Action Taken this Quarter</h4>
            </div>
            <?php
            // if the form was submitted - PHP OOP CRUD Tutorial
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // set product property values
                if (empty($_POST["text_summblob"]) || $_POST["text_summblob"] == 't') {
                    $nameErr = "Name is required";
                } else {
                    $summblob_post->blob_blob = $_POST['text_summblob'];
                }


                $summblob_post->blob_qtr = $_POST['qtr_id'];

                //post method
                $summblob_post->post_summblob();
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-horizontal" id="post_summblob">
                <div class="modal-body">

                    <?php
                    // read the quarters from the database
                    $stmt_qtr = $quarters->select_qtr();
                    $nameErr = "";
                    // put them in a select drop-down
                    echo "<div class='form-group col-sm-3'>";
                    echo "<select class='form-control' name='qtr_id'>";
                    echo "<option>Select quarter...</option>";

                    while ($row_qtr = $stmt_qtr->fetch(PDO::FETCH_ASSOC)) {
                        extract($row_qtr);
                        echo "<option value='{$qtr_name}'>{$qtr_name}</option>";
                    }

                    echo "</select></div>";
                    ?>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Action Summary:<span class="error">* <?php echo $nameErr; ?></span></label>
                        <div class="col-md-9">
                            <textarea autofocus rows="5" placeholder="" class="form-control" id="text_summblob" name="text_summblob" tabindex="1"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg pull-left" name="btn_post_summblob" id="btn_post_summblob">Enter Action</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#tgl_modal_summblob').on('shown.bs.modal', function () {
        $(this).find('textarea[name="text_summblob"]').focus();
    });
</script>