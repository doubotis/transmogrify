<?php preventAccessIfNeeded(USER_TYPE_ADMIN); ?>
<p>
    <a href="/transmogrify/admin/data-manage.php?tab=items" class="btn btn-sm btn-primary">Manage Items</a>
</p>

<table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Slot</th>
            <th>Last Updated</th>
          </tr>
        </thead>
        <tbody>
        <?php
            $req = "SELECT COUNT(*) AS count FROM items_base";
            $res = db_ask($req);
            $count = $res[0]["count"];

            $curPage = 1;
            if (!isset($_GET["page"]))
                $curPage = 1;
            else
                $curPage = intval($_GET["page"]);
            $startIndex = ($curPage-1) * 20;
    
            $req = Item::get_standard_query("en_US");
            $req .= " ORDER BY wow_native_id LIMIT $startIndex, 20";
            $res = db_ask($req);
            for ($i=0; $i < count($res); $i++) {
                $item = Item::get_from_array($res[$i]);
        ?>
            <tr id="row-id-<?php echo $item->wow_native_id ?>" class="objects-row" style="cursor: pointer;" onclick="onSelectRow(<?php echo $user->id ?>);">
            <td><?php echo $item->wow_native_id ?></td>
            <td><span class="<?php echo $item->generate_color_class_object(); ?>"><a href="" rel="item=<?php echo $item->wow_native_id ?>"><?php echo $item->name ?></a></span></td>
            <td><?php echo $item->item_class ?> - <?php echo $item->item_subclass ?> - <?php echo $item->inventory_type ?></td>
            <td><?php echo $item->last_updated ?></td>
          </tr>
       <?php } ?>
        </tbody>
</table>
<div style="text-align: center;">
    <ul class="pagination" style="margin: 0px;">
        <?php echo make_pagination($startIndex, 20, intval($count)); ?>
   </ul>
</div>
<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>