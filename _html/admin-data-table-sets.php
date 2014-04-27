<table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Set Name</th>
            <th>Item Count</th>
            <th>Likes</th>
          </tr>
        </thead>
        <tbody>
        <?php
            $req = "SELECT * FROM sets";
            $res = db_ask($req);
            for ($i=0; $i < count($res); $i++)
            {
                $set = $res[$i];
        ?>
          <tr id="row-id-<?php echo $set["id"] ?>" class="objects-row" style="cursor: pointer;" onclick="onSelectRow(<?php $set["id"] ?>);">
            <td><?php echo $set["id"] ?></td>
             <td><?php echo $set["name"] ?></td>
            <td><?php echo $set["items_count"] ?></td>
            <td><?php echo 0 ?></td>
          </tr>
       <?php } ?>
        </tbody>
</table>