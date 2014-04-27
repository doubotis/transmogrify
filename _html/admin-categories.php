<?php preventAccessIfNeeded(USER_TYPE_ADMIN); ?>
<div class="panel panel-default">
    <div class="panel-heading">Statistics</div>
    <div class="list-group">
        <?php
          include_once dirname(__FILE__) . '/../_code/utils/util.php';
          $link = curPageURL();
          $link = str_replace("http://www.psyko-foundation.fr/transmogrify/admin/", "", $link);
          $subClass = "";
          if (startsWith($link, "main.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/main.php" class="list-group-item <?php echo $subClass ?>">Main View</a>
        <?php
              if (startsWith($link, "database.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/database.php" class="list-group-item <?php echo $subClass ?>">Database</a>
        <?php
              if (startsWith($link, "data-list.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/data-list.php" class="list-group-item <?php echo $subClass ?>">Data Listing</a>
        <?php
              if (startsWith($link, "data-manage.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/data-manage.php" class="list-group-item <?php echo $subClass ?>">Data Management</a>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Gathering</div>
    <div class="list-group">
        <?php
          $link = curPageURL();
          $link = str_replace("http://www.psyko-foundation.fr/transmogrify/admin/", "", $link);
          $subClass = "";
        ?>
        <?php
          if (startsWith($link, "item-indexing.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/item-indexing.php" class="list-group-item <?php echo $subClass ?>">Indexing</a>
        <?php
          if (startsWith($link, "item-gathering.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/item-gathering.php" class="list-group-item <?php echo $subClass ?>">Item Gathering</a>
        <?php
            if (startsWith($link, "structure-gathering.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/structure-gathering.php" class="list-group-item <?php echo $subClass ?>">Structure Gathering</a>
        <?php
            if (startsWith($link, "item-temporary-store.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/item-temporary-store.php" class="list-group-item <?php echo $subClass ?>">Item Temporary Store</a>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Settings</div>
    <div class="list-group">
        <?php
          $link = curPageURL();
          $link = str_replace("http://www.psyko-foundation.fr/transmogrify/admin/", "", $link);
          $subClass = "";
          if (startsWith($link, "config.php")) { $subClass = "active"; } else { $subClass = ""; }
        ?>
        <a href="/transmogrify/admin/config.php" class="list-group-item <?php echo $subClass ?>">Real-time Configuration</a>
    </div>
</div>


