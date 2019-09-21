<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Exam
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
        $table_name = $_prefix . "pekorkort_exam";
        $sql = "CREATE TABLE $table_name (
            id               int(9)         NOT NULL AUTO_INCREMENT,
            user_id          int(9)         NOT NULL,
            questions_id     varchar(100)   NOT NULL,
            corrects_id      varchar(100)   NOT NULL,
            wrongs_id        varchar(100)   NOT NULL,
            emptys_id        varchar(100)   NOT NULL,
            status           varchar(10)    NOT NULL,
            options          text           NOT NULL,
            start_time       bigint(12)     NOT NULL,
            finish_time      bigint(12)     NOT NULL,
            
            PRIMARY KEY  (id)
          ) $_charset;";

        return $sql;
    }
}
