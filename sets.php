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
                <h2>Sets</h2>
            </div>
            <div>
                <div class="row" style="margin-bottom: 15px; margin-right: 0px;">
                    <div class="pull-right btn-group">
                        <?php
                            $subClass = "";
                            if (!isset($_GET["tab"]) || $_GET["tab"] == "base") {
                                $subClass = "active";
                            } else { $subClass = ""; }
                        ?>
                        <a href="?tab=base" class="btn btn-default <?php echo $subClass; ?>"> Base Sets</a>
                        <?php
                            if (isset($_GET["tab"]) && $_GET["tab"] == "user"){
                                $subClass = "active";
                            } else { $subClass = ""; }
                        ?>
                        <a href="?tab=user" class="btn btn-default <?php echo $subClass; ?>"> User Sets</a>
                    </div>
                </div>
                
                <?php if (!isset($_GET["tab"]) || $_GET["tab"] == "base") {
                    include_once dirname(__FILE__) . '/_html/sets-base.php';
                } else if (isset($_GET["tab"]) && $_GET["tab"] == "user"){
                    include_once dirname(__FILE__) . '/_html/sets-user.php';
                }
                ?>
                
            </div>
            
            <div class="footer">
            
            </div>
        </div>
        
        <script>
            function checkRegister()
            {
                
            }
        </script>
        
        <script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
    </body>
</html>
