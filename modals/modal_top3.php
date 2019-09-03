<div id="modal_top3" class="modal fade " role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Top 3 Accounts</h4>
            </div>
            <?php
            // if the form was submitted - PHP OOP CRUD Tutorial
            if ($_POST) {
                $summblob_post->blob_blob = $_POST['text_summblob'];
                $summblob_post->blob_qtr = $_POST['qtr_id'];

                //post method
                $summblob_post->post_summblob();
            }
            ?>

            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-horizontal" id="post_summblob">
                    <div class="row margin_btm_formrow">
                        <label for="top3_1" class="col-sm-2 control-label">Salesplan 1</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="top3_1" placeholder="" onkeyup="confirm_salesplan(this);">
                        </div>
                    </div>
                    <div class="row margin_btm_formrow">
                        <label for="top3_1" class="col-sm-2 control-label">Salesplan 2</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="top3_2" placeholder="">
                        </div>
                    </div>
                    <div class="row margin_btm_formrow">
                        <label for="top3_1" class="col-sm-2 control-label">Salesplan 3</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="top3_3" placeholder="">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
