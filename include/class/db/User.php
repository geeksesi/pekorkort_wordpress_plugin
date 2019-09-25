<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class User
{
    private $wpdb;
    private $table_name;
    public function __construct($_wpdb, $_prefix)
    {
        $this->wpdb = $_wpdb;
        $this->table_name = $_prefix . "pekorkort_user";
    }

    /**
     * retun sql query for migration
     *
     * @param   [type]  $_charset
     * @return  String  $sql
     */
    public static function migration($_charset, $_prefix)
    {
        $table_name = $_prefix . "pekorkort_user";
        $sql = "CREATE TABLE $table_name (
            id            int(9)         NOT NULL AUTO_INCREMENT,
            user_id       int(9)         NOT NULL,
            wrongs        text           NULL,            
            emptys        text           NULL,            
            seens         text           NULL,            
            PRIMARY KEY  (id)
          ) $_charset;";

        return $sql;
    }

    /**
     * set data
     *
     * @param string $_name
     * @return boolean
     */
    public function set_user(int $_user_id)
    {
        if (!is_int($_user_id))
            return false;

        $query_result = $this->wpdb->insert($this->table_name, ["user_id" => $_user_id], "%d");
        return $query_result;
    }


    /**
     * get by user_id
     *
     * @param integer $_id
     * @return boolean | array
     */
    public function get_by_user_id(int $_user_id)
    {
        if (!is_numeric($_user_id))
            return false;

        $user = $this->wpdb->get_row("SELECT * FROM " . $this->table_name . " WHERE user_id = " . $_user_id, ARRAY_A);
        return $user;
    }

    /**
     * get all users
     *
     * @return Array
     */
    public function get_all()
    {
        $users = $this->wpdb->get_results("SELECT * FROM " . $this->table_name);
        return $users;
    }


    /**
     * update wrongs
     *
     * @param integer $_id
     * @param string $_new_name
     * @return boolean
     */
    public function update_wrongs(int $_id, string $_new_wrongs)
    {
        if (!is_numeric($_id) ||  !is_string($_new_wrongs))
            return false;

        $sql_result = $this->wpdb->update($this->table_name, ["wrongs" => $_new_wrongs], ["id" => $_id], "%s", "%d");

        return $sql_result;
    }


    /**
     * update emptys
     *
     * @param integer $_id
     * @param string $_new_name
     * @return boolean
     */
    public function update_emptys(int $_id, string $_new_emptys)
    {
        if (!is_numeric($_id) ||  !is_string($_new_emptys))
            return false;

        $sql_result = $this->wpdb->update($this->table_name, ["emptys" => $_new_emptys], ["id" => $_id], "%s", "%d");

        return $sql_result;
    }


    /**
     * update seens
     *
     * @param integer $_id
     * @param string $_new_seens
     * @return boolean
     */
    public function update_seens(int $_id, string $_new_seens)
    {
        if (!is_numeric($_id) ||  !is_string($_new_seens))
            return false;

        $sql_result = $this->wpdb->update($this->table_name, ["emptys" => $_new_seens], ["id" => $_id], "%s", "%d");

        return $sql_result;
    }
}
