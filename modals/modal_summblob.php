<div id="modal_summblob" class="modal fade " role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Action Taken this Quarter</h4>
            </div>
            <form class="form-horizontal" id="post_summblob">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">Load Old Action</div>
                        <div class="col-sm-3">
                            <select class='form-control' name='category_id'>
                                <option>Select category...</option>
                                <?php
                                while ($row_summblob = $stmt_summblob->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row_summblob);
                                    echo "<option value='{$idsummary_blob}'>{$blob_qtr}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Action Summary:</label>
                        <div class="col-md-9">
                            <textarea rows="5" placeholder="" class="form-control" id="text_summblob" name="text_summblob" tabindex="1"><?php echo$blob_blob ?></textarea>
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
