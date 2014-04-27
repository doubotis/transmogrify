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
                <h3>Database</h3>
                <p>
                    <div class="alert alert-danger">
                        <strong>Not Found:</strong> This section is not yet available.
                    </div>
                    <a href="/phpmyadmin" target="_blank" class="btn btn-sm btn-primary">Open PhpMyAdmin</a>
                </p>
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
              <a href="/transmogrify/_code/action-admin.php?req=clear-gather" class="btn btn-success">Process</a>
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
