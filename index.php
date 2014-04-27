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
            <div class="col-lg-5">
                <div class="page-header">
                    <h2>Overview</h2>
                </div>
                <div style="">
                    <div style="margin-left: auto; margin-right: auto; text-align: center;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Race <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li class="dropdown-header">Alliance</li>
                          <li><a id="dropdown-race-human" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('human',selectedGender)">Human <span></span></a></li>
                          <li><a id="dropdown-race-dwarf" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('dwarf',selectedGender)">Dwarf <span></span></a></li>
                          <li><a id="dropdown-race-gnome" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('gnome',selectedGender)">Gnome <span></span></a></li>
                          <li><a id="dropdown-race-nightelf" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('nightelf',selectedGender)">Night Elf <span></span></a></li>
                          <li><a id="dropdown-race-worgen" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('worgen',selectedGender)">Worgen <span></span></a></li>
                          <li><a id="dropdown-race-draenei" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('draenei',selectedGender)">Draenei <span></span></a></li>
                          <li class="divider"></li>
                          <li class="dropdown-header">Horde</li>
                          <li><a id="dropdown-race-tauren" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('tauren',selectedGender)">Tauren <span class="glyphicon glyphicon-ok"></span></a></li>
                          <li><a id="dropdown-race-troll" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('troll',selectedGender)">Troll <span></span></a></li>
                          <li><a id="dropdown-race-scourge" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('scourge',selectedGender)">Undead <span></span></a></li>
                          <li><a id="dropdown-race-goblin" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('goblin',selectedGender)">Gobelin <span></span></a></li>
                          <li><a id="dropdown-race-bloodelf" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('bloodelf',selectedGender)">Blood Elf <span></span></a></li>
                          <li><a id="dropdown-race-orc" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('orc',selectedGender)">Orc</a></li>
                          <li class="divider"></li>
                          <li class="dropdown-header">Neutral</li>
                          <li><a id="dropdown-race-pandaren" class="dropdown-race" href="javascript:void(0)" onclick="showModelViewer('pandaren',selectedGender)">Pandaren <span></span></a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Gender <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a id="dropdown-gender-male" class="dropdown-gender" href="javascript:void(0)" onclick="showModelViewer(selectedRace,'male')">Male <span class="glyphicon glyphicon-ok"></span></a></li>
                          <li><a id="dropdown-gender-female" class="dropdown-gender" href="javascript:void(0)" onclick="showModelViewer(selectedRace,'female')">Female <span></span></a></li>
                        </ul>
                    </div>
                        
                    <button type="button" class="btn btn-primary" onclick=""  disabled><span class="glyphicon glyphicon-asterisk"></span> Manage</button>
                    <button type="button" class="btn btn-primary" onclick="" data-toggle="tooltip" title="Tooltip on bottom" disabled><span class="glyphicon glyphicon-cloud-download"></span> Import</button>
                    
                    </div>
                
                    <div id="armory-area" class="armory" style="margin-left: auto; margin-right: auto;">
                        <script>
                            $(document).ready(function() {
                                showModelViewer("<?php if (isset($_GET["r"])) { echo $_GET["r"]; } else { echo "human"; } ?>", "<?php if (isset($_GET["g"])) { echo $_GET["g"]; } else { echo "male"; } ?>");
                            });
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="page-header">
                    <h2>Equipment Selector</h2>
                </div>
                <p class="lead">Select the equipment you want to display here.</p>
                <div class="list-group">
                <?php
                    // Prepare GET values
                    $items = generate_items_from_query();
                ?>
                    <a id="equipment-slot-<?php echo SLOT_HEAD ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[0]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_HEAD ?>);">
                        <?php echo generate_item_present($items[0], SLOT_HEAD) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_SHOULDERS ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[1]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_SHOULDERS ?>);">
                        <?php echo generate_item_present($items[1], SLOT_SHOULDERS) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_BACK ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[2]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_BACK ?>);">
                        <?php echo generate_item_present($items[2], SLOT_BACK) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_CHEST ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[3]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_CHEST ?>);">
                        <?php echo generate_item_present($items[3], SLOT_CHEST) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_SHIRT ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[4]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_SHIRT ?>);">
                        <?php echo generate_item_present($items[4], SLOT_SHIRT) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_WRISTS ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[5]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_WRISTS ?>);">
                        <?php echo generate_item_present($items[5], SLOT_WRISTS) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_HANDS ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[6]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_HANDS ?>);">
                        <?php echo generate_item_present($items[6], SLOT_HANDS) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_WAIST ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[7]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_WAIST ?>);">
                        <?php echo generate_item_present($items[7], SLOT_WAIST) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_LEGS ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[8]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_LEGS ?>);">
                        <?php echo generate_item_present($items[8], SLOT_LEGS) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_FEET ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[9]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_FEET ?>);">
                        <?php echo generate_item_present($items[9], SLOT_FEET) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_MAINHAND ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[10]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_MAINHAND ?>);">
                        <?php echo generate_item_present($items[10], SLOT_MAINHAND) ?>
                    </a>
                    <a id="equipment-slot-<?php echo SLOT_OFFHAND ?>" href="javascript:void(0)" class="list-group-item equipment-slot" rel="<?php echo $items[11]->generateRelForWowHead(); ?>" onclick="showDialogBox(0,<?php echo SLOT_OFFHAND ?>);">
                        <?php echo generate_item_present($items[11], SLOT_OFFHAND) ?>
                    </a>
              </div>
                
              <div>
                  <a href="javascript:void(0)" class="btn btn-primary" onclick="previewModel();">Preview</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <span class="vertical-divider"></span>
                  <div class="pull-right">
                    <span id="count-equipment"><strong>0 objects</strong></span>&nbsp;&nbsp;&nbsp;
                    <?php if (userIsConnected() == false) { ?>
                    <span id="btn-new-set" style="display: inline-block;" data-toggle="tooltip" title="Sign up to use this feature!">
                    <a href="javascript:void(0)" id="btn-new-set" onclick="addNewSet();" type="button" class="btn btn-primary disabled" >New Set</a>
                    </span>
                    <script>$("#btn-new-set").tooltip();</script>
                    <?php } else { ?>
                    <a href="javascript:void(0)" onclick="createNewSet();" type="button" class="btn btn-primary">New Set</a>
                    <?php }?>
                    <a href="javascript:void(0)" onclick="createPermaLink();" type="button" class="btn btn-default">Permalink</a>
                  </div>
              </div>
            </div>
        
            <div class="footer">
            
            </div>
        </div>
        
        <script>
            function showDialogBox(selectedID, slot)
            {
                $("#dialog-choose-item-content").attr("src","_code/pagelets/choose-item.php?slot=" + slot);
                $("#chooseItemModal").modal();
                $("#chooseItemModal").attr("data-search-slot", slot);
                $("#myModalLabel").html("Equipment - " + $("#equipment-slot-" + slot + " strong").html());
                return;
            }

            function hideDialogBox()
            {
                $("#mask").remove();
                $('.dialog-box, .small-dialog-box').css("display","none");
            }
            
            var selectedRace = "human";
            var selectedGender = "male";
            function showModelViewer(race, gender)
            {
                if (selectedRace != race)
                    selectedRace = race;
                
                if (selectedGender != gender)
                    selectedGender = gender;
                
                $(".dropdown-race span").removeClass("glyphicon glyphicon-ok");
                $("#dropdown-race-" + selectedRace + " span").addClass("glyphicon glyphicon-ok");
                
                $(".dropdown-gender span").removeClass("glyphicon glyphicon-ok");
                $("#dropdown-gender-" + selectedGender + " span").addClass("glyphicon glyphicon-ok");
                
                previewModel();
            }
            
            function previewModel()
            {
                var items = prepareEquipment();
                var itemsJSON = JSON.stringify(items);
                
                $.ajax({
                    type: "GET",
                    url: "_code/ajax.php?action=build-viewer&gender=" + selectedGender + "&race="+ selectedRace,
                    data: { items: itemsJSON },
                    success: function(data,textStatus,jqXHR) { onModelViewerCompleted(data); },
                    error: function(jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
                });
            }
            
            function prepareEquipment()
            {
                var itemsID = [];
                $('.equipment-slot').each(function(i, obj) {
                    
                    var slotID = $(this).attr("id").replace('equipment-slot-','');
                    var relItem = $(this).attr("rel");
                    if (relItem == null || relItem == "")
                    {
                        itemsID.push({ slot: slotID, object: "" });
                    }
                    else
                    {
                        var itemID = relItem.replace('item=', '');
                        itemsID.push({ slot: slotID, object: itemID });
                    }
                });
                
                return itemsID;
                
            }
            
            function onModelViewerCompleted(data)
            {
                $("#armory-area").html(data);
            }
            
            function createPermaLink()
            {
                var url = ".?eq=";
                var itemsID = prepareEquipment();
                for (var i=0; i < itemsID.length; i++)
                {
                    var obj = itemsID[i].object;
                    url += obj;
                    if (i < itemsID.length-1)
                        url += ";";
                }
                url += "&r=" + selectedRace;
                url += "&g=" + selectedGender;
                window.open("<?php curPageURL(); ?>" + url);
            }
            
            function createNewSet()
            {
                $("#dialog-new-set").attr("src","_code/pagelets/create-new-set.php");
                $("#newSetModal").modal();
            }
        </script>
        
        <script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
        
        <!-- Modal - Choose Item-->
        <div class="modal fade" id="chooseItemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Equipment - Item Type</h4>
            </div>
            <div class="modal-body">
              <iframe src="_code/pagelets/choose-item.php" class="dialog-content" id="dialog-choose-item-content" frameborder="0" width="650" height="400" scrolling="no"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"  data-dismiss="modal" onclick="dialogSelectedObjectID = -1; confirmSelectedObjectID();">Select nothing</button>
              <button type="button" class="btn btn-success"  data-dismiss="modal" onclick="confirmSelectedObjectID();">Equip!</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal"  onclick="cancelSelectedObjectID();">Cancel</button>
            </div>
          </div>
        </div>
      </div>
        
        <!-- Modal - Create New Set-->
        <div class="modal fade" id="newSetModal" tabindex="-1" role="dialog" aria-labelledby="newSetModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Create New Set</h4>
            </div>
            <div class="modal-body">
              <iframe src="_code/pagelets/create-new-set.php" class="dialog-content" id="dialog-new-set" frameborder="0" width="650" height="320" scrolling="no"></iframe>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="confirmNewSet();">Create!</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
        
     <script>
         var dialogSelectedObjectID = -1;
         
         function confirmSelectedObjectID()
         {    
             var slot = $("#chooseItemModal").attr("data-search-slot");
             if (dialogSelectedObjectID != -1)
                $("#equipment-slot-" + slot).attr("rel","item=" + dialogSelectedObjectID);
             else
                $("#equipment-slot-" + slot).attr("rel","");
            
            refreshCountOfEquipments();
            
             $.ajax({
                    type: "GET",
                    url: "_code/ajax.php?action=get-item-equipment&objectid=" + dialogSelectedObjectID + "&slot=" + slot,
                    data: "",
                    success: function(data,textStatus,jqXHR) { $("#equipment-slot-" + slot).html(data); previewModel(); },
                    error: function(jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
                });
         }
         
         function refreshCountOfEquipments()
         {
            var c = $(".equipment-slot[rel!='']").length;
            $("#count-equipment strong").html(c + " objects");
         }
         $(document).ready(function() { refreshCountOfEquipments(); });
         
         function cancelSelectedObjectID()
         {
             
         }
         
         function confirmNewSet()
         {
             var c = $(".equipment-slot[rel!='']").length;
             var url = "";
             var itemsID = prepareEquipment();
             for (var i=0; i < itemsID.length; i++)
             {
                var obj = itemsID[i].object;
                url += obj;
                if (i < itemsID.length-1)
                    url += ";";
             }
             $("#dialog-new-set").contents().find("#hidden-field-count-items").val(c);
             $("#dialog-new-set").contents().find("#hidden-field-equipment").val(url);
             $("#dialog-new-set").contents().find("#form-new-set").submit();
         }
         
         function closeNewSet()
         {
             $('#newSetModal').modal('hide');
         }
     </script>
    </body>
</html>
