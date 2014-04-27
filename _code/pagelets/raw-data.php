<?php include_once dirname(__FILE__) . '/../web.php'; ?>
<?php include_once dirname(__FILE__) . '/../../_html/head.php'; ?>
<style>body { margin: 10px; }</style>
<div class="container">
<?php
    $req = "SELECT COUNT(*) AS count FROM gather_items";
    $res = db_ask($req);
    $count = $res[0]["count"];
                    
    $curPage = 1;
    if (!isset($_GET["page"]))
        $curPage = 1;
    else
        $curPage = intval($_GET["page"]);
    $startIndex = ($curPage-1) * 5;

    $req = "SELECT * FROM gather_items ORDER BY wow_native_id LIMIT $startIndex, 5";
    $res = db_ask($req);
?>                
<div style="text-align: center;">
    <ul class="pagination" style="margin: 0px;">
        <?php echo make_pagination($startIndex, 5, intval($count)); ?>
   </ul>
</div>
<table class="table" style="word-wrap: break-word; table-layout: fixed;">
    <thead>
      <tr>
        <th width="100px">#</th>
        <th>Raw</th>
      </tr>
    </thead>
    <tbody>
<?php
for ($i=0; $i < count($res); $i++)
{ ?>
    <tr id="row-id-<?php echo $res[$i]["wow_native_id"]; ?>" class="objects-row">
        <td><?php echo $res[$i]["wow_native_id"]; ?> 
            <?php
                $status = intval($res[$i]["status"]);
                if ($status == 1)
                {
                    $status = "<span class=\"glyphicon glyphicon-ok-sign\"/></span>";
                }
                else if ($status == 2)
                {
                    $status = "<span class=\"glyphicon glyphicon-remove-sign\"/></span>";
                }
                else if ($status == 3)
                {
                    $status = "<span class=\"glyphicon glyphicon-minus-sign\"/></span>";
                }
                else
                {
                    $status = "<span class=\"glyphicon glyphicon-question-sign\"/></span>";
                }
                echo $status;
        ?>
        </td>
        <td><?php echo $res[$i]["details"]; ?></td>
    </tr>
<?php } ?>
   </tbody>
</table>
<div style="text-align: center;">
    <ul class="pagination" style="margin: 0px;">
        <?php echo make_pagination($startIndex, 5, intval($count)); ?>
   </ul>
</div>
</div>