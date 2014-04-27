<!DOCTYPE html>
<?php include_once dirname(__FILE__) . '/../web.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <link href="../../css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="../../css/theme.css" rel="stylesheet">
        <link href="../../css/items.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container" role="main">
            <div style="margin-bottom: 10px;">
                <div class="input-group">
                    <input id="search-text" type="text" placeholder="Search an item (ID, Name, ...) or let clean for all" class="form-control">
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="button" onclick="processSearch($('#search-text').val());"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
                <?php echo generate_filter_for_slot($_GET["slot"]) ?>
            </div>
            <div style="height: 150px;">
                <div style="float: left;">
                    <div class="img-thumbnail object-preview-frame" style="background-image: url(/transmogrify/images/bg-280.jpg)">
                        <img id="object-preview"/>
                        <img id="object-preview-loader" src="/transmogrify/images/ajax-loader-128.gif" style="display: none;"/>
                    </div>
                </div>
                <div style="margin-left: 220px;">
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">
                            <a href=""><span class="glyphicon glyphicon-chevron-right" style="float: right;"></span></a>
                            <a href=""><span class="glyphicon glyphicon-chevron-left" style="float: right;"></span></a>
                          <h3 class="panel-title">0 out of 0</h3>
                        </div>-->
                        <div class="panel-body" style="height: 310px; padding: 0px; overflow-y: scroll;">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Object Name</th>
                                    <th style="width: 90px;">Type</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                        </div>
                        <div id="list-info"><div><span class="glyphicon glyphicon-search"></span><br/>Please make a search to begin...</div></div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            var selectedItem = -1;
            
            function onSelectRow(index, objectID, infoDisplayID)
            {
                $(".objects-row").removeClass("active");
                $("#row-id-" + index).addClass("active");
                showModelViewer(objectID);
                parent.dialogSelectedObjectID = objectID;
            }
            
            $('#search-text').keypress(function (e) {
                if (e.which == 13) {
                  processSearch($("#search-text").val());
                }
            });
            
            function processSearch(toSearch)
            {
                var filter="";
                $('.filter-types.active').children(0).each(function(i, obj) {
                    
                    filter += $(this).val()  + ",";
                });
                filter = filter.substring(0, filter.length-1);
                
                $("#list-info").css("display","none");
                $.ajax({
                    type: "GET",
                    url: "../ajax.php?action=search-item&text=" + toSearch + "&slot=" + "<?php echo $_GET["slot"] ?>&filter=" + filter,
                    data: "",
                    success: function(data,textStatus,jqXHR) { $(".table tbody").html(data); $('#info-unknown-item').tooltip(); },
                    error: function(jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
                });
                
            }
            
            function showModelViewer(objectID)
            {
                $("#object-preview-loader").css("display","block");
                $("#object-preview").css("display","none");
                $('#object-preview').attr('src', 'http://media.blizzard.com/wow/renders/items/item' + objectID + '.jpg').load(function()
                {
                    $("#object-preview-loader").css("display","none");
                    $("#object-preview").css("display","block");
                    $("#object-preview").attr('src',''); // prevent memory leaks as @benweet suggested
                    $('#object-preview').css('background-image', 'url(http://media.blizzard.com/wow/renders/items/item' + objectID + '.jpg)');
                });
                //$("#object-preview").html("<div class=\"model-view\" style=\"background-image: url(http://media.blizzard.com/wow/renders/items/item" + objectID + ".jpg)" + "\"/>");
            }
            
            function onSingleFilter(index)
            {
                $(".filter-types").removeClass("active");
                $("#filter-" + index).addClass("active");
            }
        </script>
        
        <script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
    </body>
</html>
