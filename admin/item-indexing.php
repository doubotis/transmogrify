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
                <h3>Indexing</h3>
                <p>
                    <?php
                        $mode = get_indexing_process_status();
                        if (get_gather_process_status() == PROCESS_NOT_EXECUTED && get_transfer_process_status() == PROCESS_NOT_EXECUTED
                                && $mode == PROCESS_NOT_EXECUTED) {
                    ?>
                        <a href="/transmogrify/_code/action-background.php?req=start-process-index" class="btn btn-sm btn-success">Start refresh indexing</a> 
                        Not indexing.
                        <?php } else if ($mode == PROCESS_NOT_EXECUTED) { ?>
                        <div class="alert alert-warning"><strong>Cannot Start Process</strong> Another process that requires Index consistency is already executing. Please stop others process before start indexing.</div>
                        <a href="/transmogrify/_code/action-background.php?req=start-process-index" class="btn btn-sm btn-success" disabled>Start refresh indexing</a>
                        Not indexing.
                        <?php } else { ?>
                        <a href="/transmogrify/_code/action-background.php?req=kill-process-index" class="btn btn-sm btn-warning" disabled>Stop refresh indexing</a>
                        Currently indexing #<?php echo get_database_config("pid-background-index"); ?>...
                        <?php } ?>
                </p>
                <p>
                    To allow gathering items from World of Warcraft API we need to know the exact indexes for all objects available in the game.
                    This process will analyze the US main page of items (<a href="http://us.battle.net/wow/en/item/">http://us.battle.net/wow/en/item/</a>)
                    to get all indexes. This step is <strong>mandatory</strong> to gather items into database.
                </p>
                <hr/>
                <h4>Index Information</h4>
                <p>
                    <?php
                        $countItemsWoWDB = get_database_config("wow-index-items-count");
                        $countPagesWoWDB = get_database_config("wow-index-pages-count");
                        $req = "SELECT COUNT(*) As c FROM gather_index";
                        $res = db_ask($req);
                        $countIndexes = intval($res[0]["c"]);
                        $percent = round(($countIndexes / $countItemsWoWDB)*100);
                    ?>
                    <?php echo $countIndexes; ?> indexes has been created out of <?php echo $countItemsWoWDB; ?> (<strong><?php echo $percent; ?>%</strong>).
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%;">
                          <span class="sr-only"><?php echo $percent ?>% Complete</span>
                        </div>
                    </div>
                    <ul>
                        <li><strong>Number of objects in World of Warcraft database:</strong> <?php echo $countItemsWoWDB ?><br/>
                        <li><strong>Number of pages in World of Warcraft Item Page:</strong> <?php echo $countPagesWoWDB ?><br/>
                        <li><strong>Number of indexes found:</strong> <?php echo $countIndexes ?>
                    </ul>
                </p>
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
