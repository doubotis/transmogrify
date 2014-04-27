<?php include_once dirname(__FILE__) . '/../web.php'; ?>
<?php include_once dirname(__FILE__) . '/../../_html/head.php'; ?>
<style>body { margin: 10px; }</style>
<div class="container">
    <?php
        if (isset($_GET["close"]) && $_GET["close"] == "true") { ?>
            <script>parent.closeNewSet();</script>
    <?php } ?>
    <?php
                printErrorMessagesFromSession();
     ?>
    <div class="well" style="padding: 50px;">
        <form id="form-new-set" class="form" enctype="multipart/form-data" role="form" method="POST" action="/transmogrify/_code/action-base.php?req=new-set">
            <div class="row">
                <div class="col-xs-4" style="position: relative; top: 7px;">
                    Name of your set:
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                      <input type="text"  name="set-name" placeholder="Name of your set" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4" style="position: relative; top: 7px;">
                    Image:
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                      <input type="file" name="set-image" allow="image/*">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4" style="position: relative; top: 7px;">
                    Public or Private:
                </div>
                <div class="col-xs-6">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default active">
                          <input type="radio" name="set-state" id="option1" value="public" checked> Public
                        </label>
                        <label class="btn btn-default">
                          <input type="radio" name="set-state" id="option1" value="private"> Private
                        </label>
                  </div>
                </div>
                
                <input type="hidden" name="count-items" id="hidden-field-count-items" value="">
                <input type="hidden" name="equipment" id="hidden-field-equipment" value="">
                
            </div>
        </form>
    </div>
</div>