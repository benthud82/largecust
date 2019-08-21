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
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // set product property values
                $summblob_post->blob_blob = $_POST['text_summblob'];
//    $summblob_post->price = $_POST['price'];
                // create the product
                if ($summblob_post->post_summblob()) {
                    echo "<div class='alert alert-success'>Product was created.</div>";
                }

                // if unable to create the product, tell the user
                else {
                    echo "<div class='alert alert-danger'>Unable to create product.</div>";
                }
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-horizontal" id="post_summblob">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Action Summary:</label>
                        <div class="col-md-9">
                            <textarea rows="5" placeholder="" class="form-control" id="text_summblob" name="text_summblob" tabindex="1">testtesttest</textarea>
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

