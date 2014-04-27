<div class="panel panel-default">
    <div class="panel-body">
        <div class="row" style="margin-top: -15px; margin-bottom: -15px;">
            <?php
                $req = "SELECT * FROM sets WHERE creator_user_id IS NOT NULL AND state = 0";
                $res = db_ask($req);
                for ($i=0; $i < count($res); $i++)
                {
                    $set = $res[$i];
            ?>
            <a target="_blank" href="<?php echo "/transmogrify/?eq=" . $set["slots"] ?>" class="container-set col-xs-3">
                    <img src="/transmogrify/_code/image.php?type=set&id=<?php echo $set["id"] ?>" class="icon-set">
                    <div style="margin-top: 8px;"><?php echo $set["name"] ?></div>
                    <?php
                        $req2 = User::get_standard_query_for_id($set["creator_user_id"]);
                        $res2 = db_ask($req2);
                        $user = User::get_from_array($res2[0]);
                    ?>
                    <div style="font-size: 12px; font-weight: normal;">by <?php echo $user->pseudo ?></div>
                    <div style="font-size: 12px; font-weight: normal;"><?php echo $set["items_count"] ?> items
                        <span style="margin-left: 10px;"><span class="glyphicon glyphicon-thumbs-up"></span> 0</span>
                    </div>

            </a>
            <?php } ?>
        </div>
    </div>
</div>