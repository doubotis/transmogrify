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
                <h2>Register <small>Enjoy the transmogrification experience!</small></h2>
            </div>
            <?php
                printErrorMessagesFromSession();
            ?>
            <?php
                if (isset($_GET["step"]) == true && $_GET["step"] == "2") { include_once dirname(__FILE__) . '/_html/register-step-2.php'; }
                else { include_once dirname(__FILE__) . '/_html/register-step-1.php'; };
            ?>
            
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
