<?php preventAccessIfNeeded(USER_TYPE_ADMIN); ?>
<ul class="nav nav-pills" style="margin-bottom: 10px;">
   <?php 
    $subClass = "";
    if (!isset($_GET["tab"]) || $_GET["tab"] == "users") { $subClass = "active"; } else { $subClass = ""; }
   ?>
  <li class="<?php echo $subClass ?>"><a href="?tab=users">Users <span class="badge">
              <?php
                $req = User::get_standard_query();
                $res = db_ask($req);
                echo count($res);
              ?>
          </span></a></li>
    <?php
    if (isset($_GET["tab"]) && $_GET["tab"] == "items") { $subClass = "active"; } else { $subClass = ""; }
    ?>
  <li class="<?php echo $subClass ?>"><a href="?tab=items">Items <span class="badge">
              <?php
                $req = Item::get_standard_query("en_US");
                $res = db_ask($req);
                echo count($res);
              ?>
          </span></a></li>
    <?php
    if (isset($_GET["tab"]) && $_GET["tab"] == "sets") { $subClass = "active"; } else { $subClass = ""; }
    ?>
  <li class="<?php echo $subClass ?>"><a href="?tab=sets">Sets <span class="badge">
            <?php
                $req = "SELECT COUNT(*) AS c FROM sets";
                $res = db_ask($req);
                echo $res[0]["c"];
              ?>
          </span></a></li>
</ul>