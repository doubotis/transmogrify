<?php

/*define( "INVENTORY_TYPE_HELMET", 1 );
define( "INVENTORY_TYPE_SHOULDERS", 3 );
define( "INVENTORY_TYPE_HANDS", 10 );
define( "INVENTORY_TYPE_LEGS", 7 );
define( "INVENTORY_TYPE_CHEST", 5 );
define( "INVENTORY_TYPE_ROBE", 20 );
define( "INVENTORY_TYPE_WRIST", 9 );
define( "INVENTORY_TYPE_CLOAK", 16 );
define( "INVENTORY_TYPE_WAIST", 6 );
define( "INVENTORY_TYPE_FEET", 8 );
define( "INVENTORY_TYPE_LEFT_HAND", 14 );
define( "INVENTORY_TYPE_ONE_HAND", 13 );
define( "INVENTORY_TYPE_RANGE", 26 );
define( "INVENTORY_TYPE_OFF_HAND", 23 );*/

class Item
{
    // Members
    var $id;
    var $wow_native_id;
    var $info_display_id;
    var $name;
    var $icon;
    var $lang;
    var $quality;
    var $item_class;
    var $item_subclass;
    var $inventory_type;
    var $last_updated;
    var $details;
    
    // Constructor
    public function __construct($lang)
    {
        $this->id = -1;
        $this->wow_native_id = -1;
        $this->info_display_id = -1;
        $this->name = "";
        $this->icon = "";
        $this->lang = $lang;
        $this->quality = 0;
        $this->item_class = 0;
        $this->item_subclass = 0;
        $this->inventory_type = 0;
        $this->details = "";
        $this->last_updated = time();
    }
    
    // Obtient une instance depuis une array donnée.
    static function get_from_array($array)
    {
        $i = new Item("en_US");
        $i->id = $array["id"];
        $i->wow_native_id = $array["wow_native_id"];
        $i->info_display_id = $array["info_display_id"];
        $i->name = stripslashes($array["name"]);
        $i->icon = $array["icon"];
        $i->lang = $array["locale"];
        $i->quality = $array["quality"];
        $i->item_class = $array["item_class"];
        $i->item_subclass = $array["item_subclass"];
        $i->inventory_type = $array["inventory_type"];
        $i->details = "";
        $i->last_updated = $array["last_updated"];
        return $i;
    }
    
    static function get_from_array_list($list)
    {
        $arr = array();
        for ($i=0; $i < count($list); $i++)
        {
            array_push($arr, get_from_array($list[$i]));
        }
        return $arr;
    }
    
    static function get_standard_query($lang)
    {
        $req = "SELECT items_base.id, items_base.wow_native_id, items_base.info_display_id, items_base.icon, items_base.quality, items_base.item_class, items_base.item_subclass, items_base.inventory_type, items_base.last_updated, items_names.text AS name, '$lang' AS locale FROM items_base INNER JOIN items_names ON (items_names.id = items_base.id) WHERE locale LIKE '$lang'";
        return $req;
    }
    
    static function get_standard_query_for_id($id, $lang)
    {
        $req = "SELECT items_base.id, items_base.wow_native_id, items_base.info_display_id, items_base.icon, items_base.quality, items_base.item_class, items_base.item_subclass, items_base.inventory_type, items_base.last_updated, items_names.text AS name, '$lang' AS locale FROM items_base INNER JOIN items_names ON (items_names.id = items_base.id) WHERE locale LIKE '$lang' AND items_base.id = $id";
        return $req;
    }
    
    function get_insert_query()
    {
        /*$req = "INSERT INTO users (id, pseudo, email, type, password) VALUES (0, '" .$this->pseudo . 
            "', '" . $this->email . "', '" . $this->type. "', '" . $this->sha1password . "')";
        return $req;*/
    }
    
    function get_update_query()
    {
        /*$req = "UPDATE users SET pseudo = '" . $this->pseudo . "', email = '" . $this->mail . "', type = '" . $this->type . "', password = '" . $this->sha1password . "', last_connected = " . $this->last_connected . " WHERE id = " . $this->id . ";";
        return $req;*/
    }
    
    function get_remove_query()
    {
        /*$req = "UPDATE users SET deleted = true AND email = NULL WHERE id = " . $this->id;
        return $req;*/
    }
    
    function generate_color_class_object()
    {
        switch ($this->quality)
        {
            case 5:
                return "item-legendary";
            case 4:
                return "item-epic";
            case 3:
                return "item-rare";
            case 2:
                return "item-unusual";
            case 1:
            default:
                return "item-common";
                
        }
    }
    
    function generateRelForWowHead()
    {
        if ($this->wow_native_id != -1)
            return "item=" . $this->wow_native_id;
        else
            return "";
    }
}

?>