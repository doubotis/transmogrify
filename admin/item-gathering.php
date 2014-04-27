<!DOCTYPE html>
<?php include_once dirname(__FILE__) . '/../_code/web.php'; ?>
<?php preventAccessIfNeeded(USER_TYPE_ADMIN); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transmogrify!</title>
        <?php include_once dirname(__FILE__) . '/../_html/head.php'; ?>
        <?php include_once dirname(__FILE__) . '/../_html/head-gc.php'; ?>
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
                <h3>Item Gathering</h3>
                    <p>
                    <?php
                        $mode = get_gather_process_status();
                        $apiQuotaExceeded = wow_api_quota_is_exceeded();
                        
                        if ($mode == "notexec" && get_transfer_process_status() != "exec") {
                    ?>
                        <a href="/transmogrify/_code/action-background.php?req=start-process-gather" class="btn btn-sm btn-success">Start gather</a> 
                        Not executing.
                        <?php } else if ($mode == "notexec") { ?>
                        <div class="alert alert-warning"><strong>Cannot Start Process</strong> A Data Transfer to Production is in Progress. You must wait the Transfer to Production to gather new items.</div>
                        <a href="/transmogrify/_code/action-background.php?req=start-process-gather" class="btn btn-sm btn-success" disabled>Start gather</a>
                        Not executing.
                        <?php } else if ($mode == "pause") { ?>
                        <a href="/transmogrify/_code/action-background.php?req=kill-process-gather" class="btn btn-sm btn-warning">Stop gather</a> 
                        Paused.
                        <?php } else { ?>
                        <a href="/transmogrify/_code/action-background.php?req=kill-process-gather" class="btn btn-sm btn-warning">Stop gather</a>
                        Currently executing #<?php echo get_database_config("pid-background-gathering"); ?>...
                        <?php } ?>
                    </p>
                    <p>The process will start at the first index not stored in Raw Data and continue until the last item index.
                        If, at any moment, the Maximum Quota is reached, the process is immediatly paused. It will be restarted as soon the Maximum Quota is restored.
                    </p>
                    <p>Data gathered by this tool are stored in a temporary data table for posterior handling.
                    </p>
                <hr/>                
                <h4>Maximum Quota Day for requesting World of Warcraft API</h4>
                <?php if ($apiQuotaExceeded == true) { ?>
                    <div class="alert alert-warning"><strong>Maximum Quota Exceeded</strong> The gathering process is paused until the quota reset. A quota reset occurs every 24h.</div>
                <?php } ?>
                <?php
                    $count = get_database_config("wow-query-quota-count");
                    $max = get_database_config("wow-query-quota-max");
                    $countInt = intval($count);
                    $maxInt = intval($max);
                    $percent = round(($countInt / $maxInt)*100);
                    $type = "success";
                    if ($percent <= 75)
                        $type = "success";
                    else if ($percent > 75 && $percent <= 95)
                        $type = "warning";
                    else if ($percent > 95)
                        $type = "danger";
                    $time = get_database_config("wow-query-quota-timestamp");
                    if ($time != "")
                        $time += 86400;
                ?>
                <p>Quota reached at <?php echo $count ?> requests out of <?php echo $max ?> (<strong><?php echo $percent ?>%</strong>). <?php if ($time != "") { echo "Quota will be reset at " . gmdate('Y-m-d H:i:s \G\M\T', $time); } ?></p>
                <div class="progress">
                    <div class="progress-bar progress-bar-<?php echo $type ?>" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%;">
                      <span class="sr-only"><?php echo $percent ?>% Complete</span>
                    </div>
                </div>
                <p>For more information, please visit the <a href="/transmogrify/admin/item-temporary-store.php">Item Temporary Store section</a>.
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
        
        <!-- Modal - Raw Data -->
        <div class="modal fade" id="rawDataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Raw Data</h4>
            </div>
            <div class="modal-body">
              <iframe src="../_code/pagelets/raw-data.php" class="dialog-content" id="dialog-choose-item-content" frameborder="0" width="560" height="400"></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
       
      <!-- Modal - Confirm Clear -->
      <div class="modal fade" id="confirmClearModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Clear</h4>
            </div>
            <div class="modal-body">
              Are you sure to clear all gathered data ?<br/>
              This will not affect Production data.
            </div>
            <div class="modal-footer">
              <a href="/transmogrify/_code/action-background.php?req=clear-gather" class="btn btn-success">Process</a>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Modal - Confirm Transfer -->
      <div class="modal fade" id="confirmTransferModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Transfer to Production</h4>
            </div>
            <div class="modal-body">
                This operation is time-consuming and <strong>cannot be cancelled</strong>.<br/>
                During transfer, it's not possible to store any new gathered data.<br/>
                Data that cannot be transfered for any reasons are preserved in Raw Data. Data successfully transfered to Production are automatically cleared.
            </div>
            <div class="modal-footer">
              <a href="/transmogrify/_code/action-background.php?req=transfer-gather-to-production" class="btn btn-success">Process</a>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      
    </body>
</html>
