<?php

include_once 'web.php';
include_once 'utils/util.php';
include_once 'utils/utils-db.php';
include_once 'utils/utils-security.php';
include_once 'utils/utils-date.php';
include_once 'utils/utils-color.php';
include_once 'locales/errors.php';
include_once 'classes/all.php';
include_once 'classes/simple_html_dom.php';

$request_type = $_GET["req"];

if ($request_type == "process-item")
{
    $hash = $_GET["hash"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    $req = "SELECT MIN(wow_native_id_index) AS c FROM `gather_index` WHERE storage_temp = 0";
    $res = db_ask($req);
    $item_id = $res[0]["c"];
    
    if (!is_numeric($item_id))
        exit(0);
    
    // Check
    if (wow_api_quota_is_exceeded())
    {
        // Passing to PAUSE mode.
        // We must stop the gather process.
        kill_process(COMMAND_GATHER);
        
        // We must now start the check process.
        start_process(COMMAND_CHECK);
        
        exit(0);
    }
    
    $req = "SELECT * FROM gather_items WHERE wow_native_id = $item_id";
    $res = db_ask($req);
    if (count($res) > 0)
    {
        // The item already exists. Do not use process to do that.
    }
    else
    {
        // We must add.
        $jsonData = file_get_contents("http://eu.battle.net/api/wow/item/" . $item_id);
        $jsonData = sql_sanitize($jsonData);
        
        $xmlData = file_get_contents("http://wowhead.com/item=" . $item_id . "?xml");
        $xmlData = sql_sanitize($xmlData);
        
        $count = get_database_config("wow-query-quota-count");
        set_database_config("wow-query-quota-count", $count + 1);
        
        $time = get_database_config("wow-query-quota-timestamp");
        if ($time == "")
            set_database_config("wow-query-quota-timestamp", time());
        
        $req = "INSERT INTO gather_items VALUES ($item_id,'$jsonData','$xmlData','server',0)";
        $res = db_ask($req);
        
        $req = "UPDATE gather_index SET storage_temp = 1 WHERE wow_native_id_index = $item_id";
        $res = db_ask($req);
        
        copy("http://media.blizzard.com/wow/renders/items/item" . $item_id . ".jpg",
                "/var/www/transmogrify/blobs/item-" . $item_id . ".jpg");
        
        // Create Thumbnail
        $ir = new ImageRenderer("/var/www/transmogrify/blobs/item-$item_id.jpg","/var/www/transmogrify/blobs/item-$item_id-short.jpg");
        $ir->doThumb();
        
        // Run substract.
        $shellExec = "java -jar /home/mysql/ImageSubstractor.jar /var/www/transmogrify/blobs/item-$item_id-short.jpg /home/mysql/bg.jpg /var/www/transmogrify/blobs/item-$item_id-color.png";
        $process = new BackgroundProcess($shellExec);
        $process->run();
        
    }
    
    exit(0);
}

if ($request_type == "check")
{
    $hash = $_GET["hash"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    if (wow_api_quota_is_exceeded())
    {
        exit(0);
    }
    
    // We must restart the analyzing process.
    $req = "SELECT MAX(wow_native_id) AS max FROM gather_items";
    $res = db_ask($req);
    $curID = $res[0]["max"];
    
    start_process(COMMAND_SHELL);
    
    // We must stop the check process.
    kill_process(COMMAND_CHECK);
    
    exit(0);

}

if ($request_type == "transfer")
{
    $hash = $_GET["hash"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    $req = "SELECT MIN(wow_native_id) AS next_id, details FROM gather_items WHERE status = 0";
    $res = db_ask($req);
    if (count($res) <= 0)
    {
        // Stop process
        kill_process(COMMAND_TRANSFER);
        
        // Clear data on gather_items temporary table
        $req = "DELETE FROM gather_items WHERE status = 1";
        $res = db_ask($req);
        
        exit(0);
    }
    
    $nextID = $res[0]["next_id"];
    $json = $res[0]["details"];
    if ($nextID == "")
    {
        // Stop process
        kill_process(COMMAND_TRANSFER);
        
        exit(0);
    }
    $json = str_replace("''''", "'", $json);
    
    if ($json == "")
    {
        $req = "UPDATE gather_items SET status = 2 WHERE wow_native_id = $nextID";
        $res = db_ask($req);
        exit(0);
    }
    
    $obj = json_decode($json, true);
    
    print("<br/><br/>");
    
    $id = $obj["id"];
    $name = addslashes($obj["name"]);
    $quality = $obj["quality"];
    $infoDisplayID = $obj["displayInfoId"];
    $inventoryType = $obj["inventoryType"];
    $icon = $obj["icon"];
    $itemClass = $obj["itemClass"];
    $itemSubClass = $obj["itemSubClass"];
    $equippable = $obj["equippable"];
    
    print("ID: $id<br/>");
    print("Name: $name<br/>");
    print("Quality: $quality<br/>");
    print("Icon: $icon<br/>");
    print("ItemClass: $itemClass<br/>");
    print("ItemSubClass: $itemSubClass<br/>");
    print("Equippable: $equippable<br/>");
    
    if ($equippable == false)
    {
        $req = "UPDATE gather_items SET status = 3 WHERE wow_native_id = $id";
        $res = db_ask($req);
        exit(0);
    }
    
    // Add item.
    $req = "INSERT INTO items_base VALUES (0,$id,'$icon',$quality,$infoDisplayID,$itemClass,$itemSubClass,$inventoryType,now())";
    $res = db_ask($req);
    print_r($res);
    
    // Query for base id.
    $req = "SELECT id FROM items_base WHERE wow_native_id = $id";
    $res = db_ask($req);
    print_r($res);
    $nativeID = $res[0]["id"];
    
    // Add the name locale.
    $req = "INSERT INTO items_names VALUES ($nativeID,'$name','en_US')";
    $res = db_ask($req);
    print_r($res);
    
    // Add item details.
    $jsonStr = sql_sanitize($json);
    $req = "INSERT INTO items_details VALUES ($nativeID,'$jsonStr')";
    $res = db_ask($req);
    print_r($res);
    
    // Update.
    $req = "UPDATE gather_items SET status = 1 WHERE wow_native_id = $id";
    $res = db_ask($req);
    print_r($res);
    
    exit(0);
}

if ($request_type == "index")
{
    $hash = $_GET["hash"];
    $page = $_GET["page"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    $htmlData = file_get_contents("http://us.battle.net/wow/en/item/?page=" . $page);
    $html = new simple_html_dom();
    $html->load($htmlData);
    $tableHtml = $html->find(".table table tbody tr");
    for ($i=1;$i < count($tableHtml); $i++)
    {
        $td = $tableHtml[$i];
        $href = $td->children(0)->children(0)->href;
        $id = str_replace("/wow/en/item/","",$href);
        print("ID: " . $id);
        
        $req = "SELECT wow_native_id_index FROM gather_index WHERE wow_native_id_index = $id";
        $res = db_ask($req);
        if (count($res) <= 0)
        {
            $req = "INSERT INTO gather_index (wow_native_id_index, storage_temp, storage_prod) VALUES ($id, 0, 0)";
            $res = db_ask($req);
        }
    }
    
    exit(0);
}

if ($request_type == "dispatch")
{
    $hash = $_GET["hash"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    if (get_transfer_process_status() == PROCESS_EXECUTING || get_indexing_process_status() == PROCESS_EXECUTING)
    {
        header("HTTP/1.1 500 Internal Error");
        die("Cannot be done now!");
    }
    
    $req = "INSERT INTO gather_upload_clients VALUES (0,NOW())";
    $res = db_ask($req);
    
    $req = "SELECT COUNT(*) AS c FROM gather_upload_clients WHERE date > (NOW() - 7200)";
    $res = db_ask($req);
    $countOfCurrentClients = $res[0]["c"];
    $limitStart = ($countOfCurrentClients * 3000);
    
    $req = "SELECT MIN(wow_native_id_index) AS c FROM `gather_index` WHERE storage_temp = 0";
    $res = db_ask($req);
    $firstIndex = $res[0]["c"];
    
    $req = "SELECT wow_native_id_index FROM gather_index WHERE wow_native_id_index > $firstIndex AND storage_temp = 0 ORDER BY wow_native_id_index ASC LIMIT $limitStart,3000";
    $res = db_ask($req);
    
    $array = array();
    for ($i=0; $i < count($res); $i++)
    {
        array_push($array, $res[$i]["wow_native_id_index"]);
    }
    
    $jsonString = json_encode($array);
    print($jsonString);
    
    exit(0);
}

if ($request_type == "image-handling")
{
    $hash = $_GET["hash"];
    $id = $_GET["id"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    if (!is_numeric($id))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    $ir = new ImageRenderer("/var/www/transmogrify/blobs/item-35.jpg","/var/www/transmogrify/blobs/item-35-short.jpg");
    $ir->doThumb();
    
    exit(0);
}

if ($request_type == "image-color")
{
    $hash = $_GET["hash"];
    $id = $_GET["id"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    if (!is_numeric($id))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    $palette = colorPalette('/var/www/transmogrify/blobs/item-' . $id . '-color.png', 10, 4);
    echo "<table>\n"; 
    foreach($palette as $color) 
    { 
       echo "<tr><td style='background-color:#$color;width:2em;'>&nbsp;</td><td>#$color</td></tr>\n"; 
    } 
    echo "</table>\n";
    
    exit(0);
}

if ($request_type == "post-item")
{
    $hash = $_GET["hash"];
    $id = $_GET["id"];
    
    if ($hash != get_database_config("security-hash"))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    if (!is_numeric($id))
    {
        header("HTTP/1.1 403 Forbidden");
        exit(0);
    }
    
    $jsonData = sql_sanitize($_POST["wowjson"]);
    $imageData = $_POST["image"];
    
    $req = "SELECT * FROM gather_items WHERE wow_native_id = $item_id";
    $res = db_ask($req);
    if (count($res) > 0)
    {
        // The item already exists. Do not use process to do that.
        print("OK RECU");
        exit(0);
    }
    
    $req = "INSERT INTO gather_items VALUES ($id,'$jsonData','','client',0)";
    $res = db_ask($req);

    $req = "UPDATE gather_index SET storage_temp = 1 WHERE wow_native_id_index = $item_id";
    $res = db_ask($req);
    
    $data = base64_decode($imageData, true);
    
    $im = imagecreatefromstring($data);
    imagejpeg($im, "/var/www/transmogrify/blobs/item-$id.jpg");
    
    // Create Thumbnail
    $ir = new ImageRenderer("/var/www/transmogrify/blobs/item-$id.jpg","/var/www/transmogrify/blobs/item-$id-short.jpg");
    $ir->doThumb();

    // Run substract.
    $shellExec = "java -jar /home/mysql/ImageSubstractor.jar /var/www/transmogrify/blobs/item-$id-short.jpg /home/mysql/bg.jpg /var/www/transmogrify/blobs/item-$id-color.png";
    $process = new BackgroundProcess($shellExec);
    $process->run();
    
    imagedestroy($im);
    
    print("OK RECU");
    
    exit(0);
}

?>