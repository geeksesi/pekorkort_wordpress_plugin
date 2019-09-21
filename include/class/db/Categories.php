<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Categories
{
    private $wpdb;
    private $table_name;
    public function __construct($_wpdb, $_prefix)
    {
        $this->wpdb = $_wpdb;
        $this->table_name = $_prefix . "pekorkort_categories";
    }

    /**
     * retun sql query for migration
     *
     * @param   [type]  $_charset
     * @return  String  $sql
     */
    public function migration($_charset)
    {
        $sql = "CREATE TABLE $this->table_name (
            id       int(9)         NOT NULL AUTO_INCREMENT,
            name     varchar(30)    NOT NULL,            
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
    public function set_data(string $_name)
    {
        if (empty($_name))
            return false;

        $query_result = $this->wpdb->insert($this->table_name, ["name" => $_name], "%s");
        return $query_result;
    }


    /**
     * get by ID
     *
     * @param integer $_id
     * @return boolean | array
     */
    public function get_id(int $_id)
    {
        if (!is_numeric($_id))
            return false;

        $category = $this->wpdb->get_row("SELECT * FROM " . $this->table_name . " WHERE id = " . $_id, ARRAY_A);
        return $category;
    }

    /**
     * get all categories
     *
     * @return Array
     */
    public function get_all()
    {
        $categories = $this->wpdb->get_results("SELECT * FROM " . $this->table_name);
        return $categories;
    }


    /**
     * update name of category
     *
     * @param integer $_id
     * @param string $_new_name
     * @return boolean
     */
    public function update_name(int $_id, string $_new_name)
    {
        if (!is_numeric($_id) ||  !is_string($_new_name))
            return false;

        $sql_result = $this->wpdb->update($this->table_name, ["name" => $_new_name], ["id" => $_id], "%s", "%d");

        return $sql_result;
    }
}
