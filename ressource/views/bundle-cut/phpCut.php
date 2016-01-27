<section id="uPhpSection" class="bundle-cut">
    <div class="row">
        <div class="col-xs-12">
            <h2>PHP data</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="well">
                <div class="form-group">
                    <form action="<?php echo($_SESSION['apiurl']) ?>" method="POST" target="_blank">
                        <input type="hidden" value="phpinfo();" name="eval">
                        <input class="btn btn-primary" type="submit" value="Phpinfo">
                    </form>
                </div>
                <form class="form" id="uRawPhpForm" action="<?php echo($_SESSION['apiurl']) ?>" method="POST" target="_blank">
                    <div class="form-group">
                        <label for="rawPhp">Raw PHP to execute:</label>
                        <textarea class="form-control" rows="5" id="rawPhp" name="eval"></textarea>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Execute">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
