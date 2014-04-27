<?php

include_once dirname(__FILE__) .'/web.php';

$request_type = $_GET["action"];

if ($request_type == "build-viewer")
{
    $race = $_GET["race"];
    $gender = $_GET["gender"];
    
    $mv = new ModelViewer();

    $mv->ObjectHeight = 550;
    $mv->ObjectWidth = 400;
    $mv->SetGender($gender);
    $mv->SetRace($race);
    
    if (isset($_GET["items"]))
    {
        $json = $_GET["items"];
        $items = json_decode($json, true);
        for ($i=0; $i < count($items); $i++)
        {
            $item = $items[$i];
            $slot = $item["slot"];
            $obj = intval($item["object"]);
            
            if ($obj != "")
            {
                $obj = sql_sanitize($obj);
            
                $req = Item::get_standard_query("en_US") . " AND wow_native_id = $obj";
                $res = db_ask($req);
                $item = Item::get_from_array($res[0]);
                $displayID = $item->info_display_id;
                if ($slot == SLOT_CHEST)
                    $slot = $item->inventory_type;
            
                $mv->EquipItem( $slot, $displayID );
            }
            
            
            
        }
    
    }
    print($mv->GetCharacterHtml());
    
    exit(0);
}

if ($request_type == "build-object")
{
    $obj = $_GET["object"];
    
    
    $mv = new ModelViewer();
    $mv->ObjectHeight = 320;
    $mv->ObjectWidth = 200;
    $mv->SetGender(GENDER_MALE);
    $mv->SetRace(RACE_TAUREN);
    $mv->UnequipAll();
    $mv->EquipItem(SLOT_CHEST, $obj);
    print($mv->getObjectHTML($obj));
    
    exit(0);
}

if ($request_type == "search-item")
{
    $text = sql_sanitize($_GET["text"]);
    $slot = sql_sanitize($_GET["slot"]);
    $filter = $_GET["filter"];
    $inventoryTypeSQLCondition = slot_manage_inventory_type(intval($slot));
    $filterSQLCondition = slot_manage_item_filter($filter);
    
    if (is_numeric($text))
    {
        // Threated as object identifier
        $req = Item::get_standard_query("en_US") . " AND wow_native_id = $text AND inventory_type IN ($inventoryTypeSQLCondition) AND ($filterSQLCondition)";
        $res = db_ask($req);
        if (count($res) <= 0)
        {     
            $content = "<tr id=\"row-id-" . "0" . "\" class=\"objects-row clickable\" style=\"cursor: pointer;\" onclick=\"onSelectRow(" . 0 . "," . $text . "," . -1 . ");\">";
            $content .= "<td>" . $text . "</td>";
            $content .= "<td>Unknown item #" . $text . " <span id=\"info-unknown-item\" data-toggle=\"tooltip\" title=\"This item identifier is not in our database, but we can try to handle it.\" class=\"badge pull-right\">?</span></td>";
            $content .= "<td>Unknown</td>";
            $content .= "</tr>";
            print($content);
        }
        else
        {
            for ($i=0; $i < count($res); $i++)
            {
                $item = Item::get_from_array($res[$i]);
                $content = "<tr id=\"row-id-" . $i . "\" class=\"objects-row clickable\" style=\"cursor: pointer;\" onclick=\"onSelectRow(" . $i . "," . $item->wow_native_id . "," . $item->info_display_id . ");\">";
                $content .= "<td>" . $item->wow_native_id . "</td>";
                $content .= "<td><span class=\"" . $item->generate_color_class_object() . "\"><a href=\"javascript:void(0)\" rel=\"item=" . $item->wow_native_id . "\">" . $item->name . "</a></span></td>";
                $content .= "<td>" . subclass_name($item->item_class, $item->item_subclass) . "</td>";
                $content .= "</tr>";
                print($content);
            }
        }
    }
    else
    {
        // Threated as name
        $req = Item::get_standard_query("en_US") . " AND items_names.text LIKE '%$text%' AND items_base.inventory_type IN ($inventoryTypeSQLCondition) AND ($filterSQLCondition)";
        $res = db_ask($req);
        for ($i=0; $i < count($res); $i++)
        {
            $item = Item::get_from_array($res[$i]);
            $content = "<tr id=\"row-id-" . $i . "\" class=\"objects-row clickable\" style=\"cursor: pointer;\" onclick=\"onSelectRow(" . $i . "," . $item->wow_native_id . "," . $item->info_display_id . ");\">";
            $content .= "<td>" . $item->wow_native_id . "</td>";
            $content .= "<td><span class=\"" . $item->generate_color_class_object() . "\"><a href=\"javascript:void(0)\" rel=\"item=" . $item->wow_native_id . "\">" . $item->name . "</a></span></td>";
            $content .= "<td>" . subclass_name($item->item_class, $item->item_subclass) . "</td>";
            $content .= "</tr>";
            print($content);
        }
    }
    
    exit(0);
}

if ($request_type == "get-item-equipment")
{
    $objectid = sql_sanitize($_GET["objectid"]);
    $slot = sql_sanitize($_GET["slot"]);
    
    if ($objectid == -1)
    {
        $item = new Item("en_US");
        $item->id = -1;
        $content = generate_item_present($item, $slot);
        print($content);
        
        exit(0);
    }
    
    $req = Item::get_standard_query("en_US") . " AND wow_native_id = $objectid";
    $res = db_ask($req);
    if (count($res) <= 0)
        exit(0);
    $item = Item::get_from_array($res[0]);
    
    $content = generate_item_present($item, $slot);
    print($content);
    
    exit(0);
}

$json = json_encode("Request Type not allowed");
print($json);


?>
