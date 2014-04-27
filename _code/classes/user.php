<?php

define( "USER_TYPE_SIMPLE", "simple" );
define( "USER_TYPE_MODERATOR", "moderator" );
define( "USER_TYPE_ADMIN", "admin" );
define( "USER_TYPE_SUPERADMIN", "superadmin" );

class User
{
    // Members
    var $id;
    var $pseudo;
    var $mail;
    var $type;
    var $sha1password;
    var $last_connected;
    
    // Constructor
    function User() {
        $this->id = 0;
        $this->pseudo = "";
        $this->mail = "";
        $this->type = USER_TYPE_SIMPLE;
        $this->sha1password = sha1("");
        $this->last_connected = time();
    }
    
    // Obtient une instance depuis une array donnée.
    static function get_from_array($array)
    {
        $u = new User();
        $u->id = $array["id"];
        $u->pseudo = $array["pseudo"];
        $u->mail = $array["email"];
        $u->type = $array["type"];
        $u->sha1password = $array["password"];
        $u->last_connected = $array["last_connected"];
        return $u;
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
    
    static function get_standard_query()
    {
        $req = "SELECT users.id, users.pseudo, users.type, users.password, users.email, users.last_connected FROM users WHERE users.deleted = false";
        return $req;
    }
    
    static function get_standard_query_for_id($id)
    {
        $req = "SELECT users.id, users.pseudo, users.type, users.password, users.email, users.last_connected FROM users WHERE users.deleted = false AND id = " . $id;
        return $req;
    }
    
    function get_insert_query()
    {
        $req = "INSERT INTO users (id, pseudo, email, type, password) VALUES (0, '" .$this->pseudo . 
            "', '" . $this->email . "', '" . $this->type. "', '" . $this->sha1password . "')";
        return $req;
    }
    
    function get_update_query()
    {
        $req = "UPDATE users SET pseudo = '" . $this->pseudo . "', email = '" . $this->mail . "', type = '" . $this->type . "', password = '" . $this->sha1password . "', last_connected = " . $this->last_connected . " WHERE id = " . $this->id . ";";
        return $req;
    }
    
    function get_update_query_connection()
    {
        $req = "UPDATE users SET pseudo = '" . $this->pseudo . "', email = '" . $this->mail . "', type = '" . $this->type . "', password = '" . $this->sha1password . "', last_connected = NOW() WHERE id = " . $this->id . ";";
        return $req;
    }
    
    function get_remove_query()
    {
        $req = "UPDATE users SET deleted = true AND email = NULL WHERE id = " . $this->id;
        return $req;
    }
}

?>