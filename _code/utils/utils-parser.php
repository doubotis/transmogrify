<?php

function generate_items_from_query()
{
    $items = array();
    
    $content;
    if (!isset($_GET["eq"]))
        $content = ";;;;;;;;;;;";
    else
        $content = $_GET["eq"];
    
    try
    {
        $values = split(';', $content);
        for ($i=0; $i < count($values); $i++)
        {
            $val = $values[$i];
            if ($val == "")
            {
                $it = new Item("en_US");
                array_push($items, $it);
            }
            else
            {
                $val = sql_sanitize($val);
                $req = Item::get_standard_query("en_US") . " AND wow_native_id = $val";
                $res = db_ask($req);
                if (is_array($res) == false || count($res) <= 0)
                {
                    $it = new Item("en_US");
                    array_push($items, $it);
                }
                else
                {
                    $it = Item::get_from_array($res[0]);
                    array_push($items, $it);
                }
            }
        }
        if (count($items) < 11)
            return generate_default_items();
        else
            return $items;
        
    } catch (Exception $e)
    {
        return generate_default_items();
    }
    
}

function generate_default_items()
{
    $items = array();
    
    $i = new Item("en_US");
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    array_push($items, $i);
    
    return $items;
}

function generate_item_present($item, $slot)
{
    $slotName = slot_name($slot);
    
    if ($item->id == -1)
    {
        $content = "<img class=\"item-icon\" src=\"images/unknown-item.jpg\"/>";
        $content .= "<strong>$slotName</strong><span class=\"item-name item-none\">(Click to equip an item)</span>";
        return $content;
    }
    else
    {
        $content = "<img class=\"item-icon\" src=\"http://media.blizzard.com/wow/icons/56/" . $item->icon . ".jpg\"/>";
        $content .= "<strong>$slotName</strong><span class=\"item-name " . $item->generate_color_class_object() . "\">" . $item->name . "</span>";
        return $content;
    }
}

?>
