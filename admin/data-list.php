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
                <h3>Data Listing</h3>
                <p style="margin-bottom: 25px;">
                    See the complete list of data used in Production tables.
                </p>
                <?php include_once dirname(__FILE__) . '/../_html/admin-data-tabs.php'; ?>
                <hr/>
                
                <?php if (!isset($_GET["tab"]) || $_GET["tab"] == "users") {
                    include_once dirname(__FILE__) . '/../_html/admin-data-table-users.php';
                } else if (isset($_GET["tab"]) && $_GET["tab"] == "items"){
                    include_once dirname(__FILE__) . '/../_html/admin-data-table-items.php';
                } else if (isset($_GET["tab"]) && $_GET["tab"] == "sets") {
                    include_once dirname(__FILE__) . '/../_html/admin-data-table-sets.php';
                }
                ?>
                
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
