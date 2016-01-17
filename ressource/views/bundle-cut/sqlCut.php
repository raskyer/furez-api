<section id="uMysqlSection" class="bundle-cut">
    <div class="row">
        <div class="col-xs-12">
            <h2>MySQL</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="well">
                <span id="uStatusConnect" class="label label-default">Unconnect</span>
                <form id="uSQLConnectForm" class="form-inline">
                    <div class="form-group">
                        <label>Host :</label>
                        <input type='text' name='host' id='uSQL1' class='form-control'>
                    </div>
                    <div class="form-group">
                        <label>Username :</label>
                        <input type='text' name='username' id='uSQL2' class='form-control'>
                    </div>
                    <div class="form-group">
                        <label>Password :</label>
                        <input type='text' name='password' id='uSQL3' class='form-control'>
                    </div>
                    <input type='submit' class='btn btn-default' id='uSQLSubmit' value='Connect'>
                </form>
                <hr>
                <form id="uSQLCommandForm" class="form">
                    <div class="form-group">
                        <label for="rawSql">Raw SQL to execute:</label>
                        <textarea class="form-control" rows="5" id="rawSql" name="sql" disabled style="background:#666;"></textarea>
                    </div>
                    <input type='submit' class='btn btn-success' value='Execute' disabled>
                </form><br>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">MySQL Dump</div>

                <table id='uRawResult' class="table">
                </table>
            </div>
        </div>
    </div>
</section>
