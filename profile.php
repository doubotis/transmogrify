<!DOCTYPE html>
<?php include_once dirname(__FILE__) . '/_code/web.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transmogrify!</title>
        <?php include_once dirname(__FILE__) . '/_html/head.php'; ?>
    </head>
    <body class="main-site" role="document">
        <?php include_once dirname(__FILE__) . '/_html/body-navbar.php'; ?>
        <div class="container" role="main">
            <div class="page-header">
                <h2>Welcome in your profile</h2>
            </div>
            <p class="lead">Your last connected was ?.</p>
            <?php
                printErrorMessagesFromSession();
            ?>
            
            <?php
                if (userAccountType() == USER_TYPE_ADMIN || userAccountType() == USER_TYPE_SUPERADMIN) {
            ?>
            <div>
                <a href="/transmogrify/admin/main.php" class="btn btn-primary">Admin Panel</a>
            </div>
            <?php } ?>
            
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
