<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Categories
{
    private $wpdb;
    function __construct($_wpdb)
    { 
        $this->wpdb = $_wpdb;
    }


    /**
     * retun sql query for migration
     *
     * @param   String  $_prefix
     * @param   String  $_charset
     * @return  String  $sql
     */
    function migration($_prefix, $_charset)
    {
        $table_name = $_prefix . "pekorkort_categories";
        $sql = "CREATE TABLE $table_name (
            id       int(9)         NOT NULL AUTO_INCREMENT,
            name     varchar(30     NOT NULL,            
            PRIMARY KEY  (id)
          ) $_charset;";

        return $sql;
    }
}
