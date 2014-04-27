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
                <h3>Item Temporary Store</h3>
                <p>Data gathered by the <strong>Item Gathering tool</strong> (<a href="/transmogrify/admin/item-gathering.php">See the Item Gathering section</a>) are stored in a temporary data table. To make items gathered
                    by this way available as real items available for everyone, you must run a Transfer from the temporary data table to the final Item Data Store.
                </p>
                <p>Data of this temporary store could be managed here.
                </p>
                <hr/>
                <h4>Overview</h4>
                <?php
                    $req = "SELECT COUNT(*) AS count FROM gather_items";
                    $res = db_ask($req);
                    $count = $res[0]["count"];
                    $req = "SELECT COUNT(*) AS count FROM gather_index";
                    $res = db_ask($req);
                    $max = $res[0]["count"];
                    $countInt = intval($count);
                    $maxInt = intval($max);
                    if ($maxInt > 0)
                        $percent = round(($countInt / $maxInt)*100);
                    else
                        $percent = 0;
                ?>
                <p>Raw Data contains <?php echo $count ?> items out of <?php echo $max ?> (<strong><?php echo $percent ?>%</strong>).</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%;">
                      <span class="sr-only"><?php echo $percent ?>% Complete</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?php include_once dirname(__FILE__) . '/../_html/charts/googlecharts-gather-source.php'; ?>
                    </div>
                    <div class="col-xs-6">
                        <?php include_once dirname(__FILE__) . '/../_html/charts/googlecharts-gather-values.php'; ?>
                    </div>
                </div>
                
                <h4>Management</h4>
                <?php if (get_gather_process_status() == "exec" || get_gather_process_status() == "paused") { ?>
                    <div class="alert alert-warning"><strong>Cannot transfer</strong> Please stop any gathering process before transfer to Production or clear data in the temporary table.</div>
                    <p>
                        <button data-toggle="modal" data-target="#rawDataModal" class="btn btn-sm btn-default">See Content</button>
                        <button data-toggle="modal" data-target="#confirmTransferModal" class="btn btn-sm btn-success" disabled><span class="glyphicon glyphicon-floppy-save"></span> Start handling</button>
                        <button data-toggle="modal" data-target="#confirmClearModal" class="btn btn-sm btn-danger" disabled><span class="glyphicon glyphicon-floppy-remove"></span> Clear</button>
                    </p>
                <?php } else if (get_transfer_process_status() == "notexec") { ?>
                    <p>
                        <button data-toggle="modal" data-target="#rawDataModal" class="btn btn-sm btn-default">See Content</button>
                        <button data-toggle="modal" data-target="#confirmTransferModal" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-floppy-save"></span> Start handling</button>
                        <button data-toggle="modal" data-target="#confirmClearModal" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> Clear</button>
                    </p>
                <?php } else { ?>
                    <p>
                        <button data-toggle="modal" data-target="#rawDataModal" class="btn btn-sm btn-default">See Content</button>
                        <a href="/transmogrify/_code/action-background.php?req=stop-process-transfer" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-floppy-save"></span> Stop handling</a>
                        <button data-toggle="modal" data-target="#confirmClearModal" class="btn btn-sm btn-danger" disabled><span class="glyphicon glyphicon-floppy-remove"></span> Clear</button>
                    </p>
                <?php } ?>
                    
                <?php
                    $req = "SELECT COUNT(*) AS count FROM gather_items";
                    $res = db_ask($req);
                    $max = $res[0]["count"];
                    $req = "SELECT COUNT(*) AS count FROM gather_items WHERE status != 0";
                    $res = db_ask($req);
                    $count = $res[0]["count"];
                    if ($max != 0)
                        $percent = round(($count / $max)*100);
                    else
                        $percent = 0;
                ?>
                <p>The Transfer process has handled <?php echo $count ?> items out of <?php echo $max ?> in the temporary data table (<strong><?php echo $percent ?>%</strong>).</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent ?>%;">
                      <span class="sr-only"><?php echo $percent ?>% Complete</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?php include_once dirname(__FILE__) . '/../_html/charts/googlecharts-gather-transfer.php'; ?>
                    </div>
                </div>
                
                
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
              <h4 class="modal-title" id="myModalLabel">Start handling</h4>
            </div>
            <div class="modal-body">
                During transfer, it's not possible to store any new gathered data.<br/>
                Data that cannot be transfered for any reasons are preserved in Raw Data. Data successfully transfered to Production are automatically cleared.
            </div>
            <div class="modal-footer">
              <a href="/transmogrify/_code/action-background.php?req=start-process-transfer" class="btn btn-success">Process</a>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      
    </body>
</html>
