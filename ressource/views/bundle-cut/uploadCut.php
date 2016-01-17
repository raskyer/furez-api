<section class="bundle-cut">
    <div class="row">
        <div class="col-xs-12">
            <h2>Upload File</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="well">
                <form method="post" action="<?php echo($this->router->generate('uploadElement')) ?>" enctype="multipart/form-data" class="form">
                    <div class="form-group">
                        <label for="exportdir">Upload directory: </label>
                        <input type="text" id="exportdir" class="form-control" name="exportdir" value="<?php echo(str_replace('\\', '/', $cur_dir)) ?>">
                    </div>
                    <div class="form-group">
                        <input type="file" name="file" size="30">
                    </div>

                    <input type="submit" class="btn btn-success" value="Upload">
                </form>
            </div>
        </div>
    </div>
</section>
