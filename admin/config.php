<!DOCTYPE html>
<?php include_once dirname(__FILE__) . '/../_code/web.php'; ?>
<?php preventAccessIfNeeded(USER_TYPE_ADMIN); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transmogrify!</title>
        <?php include_once dirname(__FILE__) . '/../_html/head.php'; ?>
    </head>
    <body class="main-site" role="document">
        <?php include_once dirname(__FILE__) . '/../_html/body-navbar.php'; ?>
        <div class="container" role="main">
            <div class="page-header">
                <h2>Admin Panel</h2>
            </div>
            <?php
                printErrorMessagesFromSession();
            ?>
            <div class="col-lg-4">
                <?php include_once dirname(__FILE__) . '/../_html/admin-categories.php'; ?>
            </div>
            <div class="col-lg-8">
                <h3>Real-time Configuration</h3>
                <div class="alert alert-warning">
                    <strong>Warning!</strong> These config values must be changed carrefully and are used in real-time by the server.
                </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th>Config Name</th>
                        <th>Config Value</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $req = "SELECT * FROM config ORDER BY name DESC";
                        $res = db_ask($req);
                        for ($i=0; $i < count($res); $i++) {
                            $configName = $res[$i]["name"];
                            $configValue = $res[$i]["value"];
                    ?>
                      <tr id="row-id-<?php echo $user->id ?>" class="objects-row">
                        <td><?php echo $configName ?></td>
                        <td>
                            <form method="POST" action="/transmogrify/_code/action-admin.php?req=set-config&name=<?php echo $configName ?>">
                                <div class="input-group" style="width: 300px;">
                                    <input name="config-value" class="form-control" type="text" value="<?php echo $configValue ?>"/>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button>
                                    </span>
                                </div>
                            </form>
                        </td>
                      </tr>
                   <?php } ?>
                    </tbody>
                </table>
                </div>

            <div class="footer">
            
            </div>
        </div>
        
        <div id="dialog-choose-item-box" class="dialog-box">
            <iframe src="_code/pagelets/choose-item.php" class="dialog-content" id="dialog-choose-item-content" frameborder="0" width="630" height="500"></iframe>
        </div>
        
        <script>
            function checkRegister()
            {
                
            }
        </script>
        
        <script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
    </body>
</html>
