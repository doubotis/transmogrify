<?php



function slot_manage_inventory_type($slot)
{
    if ($slot == SLOT_MAINHAND)
    {
        return "$slot,17,13,15,21,26";
    }
    else if ($slot == SLOT_OFFHAND)
    {
        return "$slot,13,23";
    }
    else if ($slot == SLOT_CHEST)
    {
        return "$slot,20";
    }
    else    
        return "$slot";
}

function slot_manage_item_class($itemClass, $itemSubClass)
{
    $ic = sql_sanitize($itemClass);
    $isc = sql_sanitize($itemSubClass);
    
    $ic = str_replace("DROP","",$ic);
    $ic = str_replace("DELETE","",$ic);
    $ic = str_replace("INSERT","",$ic);
    $ic = str_replace("FROM","",$ic);
    $ic = str_replace("REPLACE","",$ic);
    
    $isc = str_replace("DROP","",$isc);
    $isc = str_replace("DELETE","",$isc);
    $isc = str_replace("INSERT","",$isc);
    $isc = str_replace("FROM","",$isc);
    $isc = str_replace("REPLACE","",$isc);
    
    return "( item_class = $ic AND item_subclass = $isc )";
}

function slot_manage_item_filter($filter)
{
    $sqlSentence = "";
    $arrs = split(",", $filter);
    for ($i=0; $i < count($arrs); $i++)
    {
        $elements = split(":", $arrs[$i]);
        $itemClass = $elements[0];
        $itemSubClass = $elements[1];
        
        if ($i > 0)
            $sqlSentence .= " OR " . slot_manage_item_class ($itemClass, $itemSubClass);
        else
            $sqlSentence .= slot_manage_item_class ($itemClass, $itemSubClass);
    }
    return $sqlSentence;
}

function slot_name($slot)
{
    switch ($slot)
    {
        case SLOT_HEAD:
            return "Head";
        case SLOT_SHOULDERS:
            return "Shoulders";
        case SLOT_CHEST:
            return "Chest";
        case SLOT_BACK:
            return "Cloak";
        case SLOT_SHIRT:
            return "Shirt";
        case SLOT_FEET:
            return "Feet";
        case SLOT_HANDS:
            return "Hands";
        case SLOT_LEGS:
            return "Legs";
        case SLOT_WAIST:
            return "Waist";
        case SLOT_WRISTS:
            return "Wrist";
        case SLOT_MAINHAND:
        case 17:
        case 13:
        case 15:
        case 26:
            return "M.H.";
        case SLOT_OFFHAND:
        case 13:
        case 23:
            return "O.H.";
        default:
            return "Unknown";
    }
}

function subclass_name($class, $subclass)
{
    if ($class == 4)        // Armors
    {
        switch($subclass)
        {
            case 0:
                return "Shirt";
            case 1:
                return "Cloth";
            case 2:
                return "Leather";
            case 3:
                return "Mail";
            case 4:
                return "Plate";
            case 6:
                return "Shield";
            default:
                return "Unknown";
        }
    }
    else if ($class == 2)   // Weapons
    {
        switch($subclass)
        {
            case 0:
                return "1H Axe";
            case 1:
                return "2H Axe";
            case 2:
                return "Bow";
            case 3:
                return "Gun";
            case 4:
                return "1H Mace";
            case 5:
                return "2H Mace";
            case 6:
                return "Polearn";
            case 7:
                return "1H Sword";
            case 8:
                return "2H Sword";
            case 10:
                return "Staff";
            case 13:
                return "Fist";
            case 15:
                return "Dagger";
            case 19:
                return "Wand";
            default:
                return "Unknown";
        }
    }
    else
        return "Unknown";
}

function generate_filter_for_slot($slot)
{
    $type = "armor";
    switch ($slot)
    {
        case SLOT_HEAD:
        case SLOT_SHOULDERS:
        case SLOT_CHEST:
        case SLOT_FEET:
        case SLOT_HANDS:
        case SLOT_LEGS:
        case SLOT_WAIST:
        case SLOT_WRISTS:
            $type = "armor";
            break;            
        case SLOT_BACK:
            $type = "back";
            break;
        case SLOT_SHIRT:
        case 20:
            $type = "shirt";
            break;
        case SLOT_MAINHAND:
        case 17:
        case 13:
        case 15:
        case 26:
            $type = "mainhand";
            break;
        case SLOT_OFFHAND:
        default:
        case 13:
        case 23:
            $type = "offhand";
            break;
    }
    
    $content = "<span id=\"filter-tooltip\" style=\"display: inline-block;\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Double-click to filter only one.\">";
    $content .= "<div class=\"btn-group\" style=\"margin-top: 10px;\" data-toggle=\"buttons\">";
    if ($type == "armor")
    {
        $content .= "<label id=\"filter-0\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(0);\">";
        $content .= "<input type=\"checkbox\" value=\"4:0\"> Shirt";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-1\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(1);\">";
        $content .= "<input  type=\"checkbox\" value=\"4:1\"> Cloth";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-2\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(2);\">";
        $content .= "<input type=\"checkbox\" value=\"4:2\"> Leather";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-3\"class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(3);\">";
        $content .= "<input type=\"checkbox\" value=\"4:3\"> Mail";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-4\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(4);\">";
        $content .= "<input type=\"checkbox\" value=\"4:4\"> Plate";
        $content .= "</label>";
    }
    else if ($type == "mainhand")
    {
        // All weapons : 2H Mace, 2H Sword, 2H Axe, 1H Mace, 1H Sword, 1H Axe, Bows...
        $content .= "<label id=\"filter-0\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(0);\">";
        $content .= "<input type=\"checkbox\" value=\"2:2,2:18,2:3\"> Physical Ranged";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-1\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(1);\">";
        $content .= "<input type=\"checkbox\" value=\"2:19\"> Wand";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-2\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(2);\">";
        $content .= "<input type=\"checkbox\" value=\"2:0,2:4,2:7\"> 1H Weapon";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-3\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(3);\">";
        $content .= "<input type=\"checkbox\" value=\"2:1,2:5,2:8\"> 2H Weapon";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-4\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(4);\">";
        $content .= "<input type=\"checkbox\" value=\"2:6,2:10\"> Staff";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-5\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(5);\">";
        $content .= "<input type=\"checkbox\" value=\"2:15\"> Dagger";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-6\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(6);\">";
        $content .= "<input type=\"checkbox\" value=\"2:13\"> Fist";
        $content .= "</label>";
    }
    else if ($type == "back")
    {
        $content .= "<label id=\"filter-0\" class=\"filter-types btn btn-default active disabled\" ondblclick=\"onSingleFilter(0);\">";
        $content .= "<input  type=\"checkbox\" value=\"4:1\"> Cloth";
        $content .= "</label>";
    }
    else if ($type == "shirt")
    {
        $content .= "<label id=\"filter-0\" class=\"filter-types btn btn-default active disabled\" ondblclick=\"onSingleFilter(0);\">";
        $content .= "<input type=\"checkbox\" value=\"4:0\"> Shirt";
        $content .= "</label>";
    }
    else if ($type == "offhand")
    {
        // All weapons
        $content .= "<label id=\"filter-0\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(0);\">";
        $content .= "<input type=\"checkbox\" value=\"2:0,2:4,2:7\"> 1H Weapon";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-1\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(1);\">";
        $content .= "<input type=\"checkbox\" value=\"2:1,2:5,2:8\"> 2H Weapon";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-2\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(2);\">";
        $content .= "<input type=\"checkbox\" value=\"2:6,2:10\"> Staff";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-3\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(3);\">";
        $content .= "<input type=\"checkbox\" value=\"2:15\"> Dagger";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-4\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(4);\">";
        $content .= "<input type=\"checkbox\" value=\"2:13\"> Fist";
        $content .= "</label>";
        
        $content .= "<label id=\"filter-5\" class=\"filter-types btn btn-default active\" ondblclick=\"onSingleFilter(5);\">";
        $content .= "<input type=\"checkbox\" value=\"4:6\"> Shield";
        $content .= "</label>";
    }
    
    $content .= "</div>";
    $content .= "</span>";
    $content .= "<script>$(\"#filter-tooltip\").tooltip({delay: { show: 1000, hide: 100 }});</script>";
    
    return $content;
}

?>
