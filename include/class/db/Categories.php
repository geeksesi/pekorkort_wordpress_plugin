<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Categories
{
    function __construct()
    { }


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
            name     int(9)         NOT NULL,            
            PRIMARY KEY  (id)
          ) $_charset;";

        return $sql;
    }
}
