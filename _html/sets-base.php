<div class="panel panel-default">
    <div class="panel-body">
        <div class="row" style="margin-top: -15px; margin-bottom: -15px;">
            <?php
                $req = "SELECT * FROM sets WHERE creator_user_id IS NULL";
                $res = db_ask($req);
                for ($i=0; $i < count($res); $i++)
                {
                    $set = $res[$i];
            ?>
            <a target="_blank" href="<?php echo "/transmogrify/?eq=" . $set["slots"] ?>" class="container-set col-xs-3">
                    <img class="icon-set" style="background-image: url(/transmogrify/images/no-set-image.png)">
                    <div style="margin-top: 8px;"><?php echo $set["name"] ?></div>
                    <div style="font-size: 12px; font-weight: normal;"><?php echo $set["items_count"] ?> items
                        <span style="margin-left: 10px;"><span class="glyphicon glyphicon-thumbs-up"></span> 0</span>
                    </div>

            </a>
            <?php } ?>
        </div>
    </div>
</div>