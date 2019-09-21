<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Exam
{
    private $wpdb;
    private $table_name;
    public function __construct($_wpdb, $_prefix)
    {
        $this->wpdb = $_wpdb;
        $this->table_name = $_prefix . "pekorkort_exam";
    }


    /**
     * retun sql query for migration
     *
     * @param   String  $_prefix
     * @param   String  $_charset
     * @return  String  $sql
     */
    public function migration($_charset)
    {
        $sql = "CREATE TABLE $this->table_name (
            id               int(9)         NOT NULL AUTO_INCREMENT,
            user_id          int(9)         NOT NULL,
            questions_id     varchar(100)   NOT NULL,
            corrects_id      varchar(100)   NULL,
            wrongs_id        varchar(100)   NULL,
            emptys_id        varchar(100)   NULL,
            status           varchar(10)    NOT NULL,
            options          text           NOT NULL,
            start_time       bigint(12)     NOT NULL,
            finish_time      bigint(12)     NULL,
            
            PRIMARY KEY  (id)
          ) $_charset;";

        return $sql;
    }

    /**
     * set basics of exam
     *
     * @param integer $_user_id
     * @param string $_questions_id
     * @param string $_status
     * @param string $_options
     * @return boolean|array
     */
    public function set_data(int $_user_id, string $_questions_id, string $_status, string $_options)
    {
        if (empty($_user_id) || empty($_questions_id) || empty($_status) || empty($_options))
            return false;

        $query_result = $this->wpdb->insert($this->table_name, [
            "user_id" => $_user_id,
            "questions_id" => $_questions_id,
            "status" => $_status,
            "options" => $_options,
            "start_time" => time(),
        ], [
            "user_id" => "%d",
            "questions_id" => "%s",
            "status" => "%s",
            "options" => "%s",
            "start_time" => "%d",
        ]);

        return $query_result;
    }

    /**
     * set some value after finish exam
     *
     * @param integer $_exam_id
     * @param string $_corrects_id
     * @param string $_wrongs_id
     * @param string $_emptys_id
     * @return boolean|array
     */
    public function set_after_finish(int $_exam_id, string $_corrects_id = "", string $_wrongs_id = "", string $_emptys_id = "")
    {
        if (!is_numeric($_exam_id))
            return false;

        $sql_result = $this->wpdb->update($this->table_name, [
            "corrects_id" => $_corrects_id,
            "wrongs_id" => $_wrongs_id,
            "emptys_id" => $_emptys_id,
            "finish_time" => time(),
        ], ["id" => $_exam_id], [
            "corrects_id" => "%s",
            "wrongs_id" => "%s",
            "emptys_id" => "%s",
            "finish_time" => "%d",
        ], "%d");

        return sql_result;
    }

    /**
     * get exams by use id
     *
     * @param integer $_user_id
     * @return boolean|array
     */
    public function get_user_exams(int $_user_id)
    {
        if (!is_numeric($_user_id))
            return false;

        $query_string = "SELECT * FROM " . $this->table_name . "where user_id=" . $_user_id;
        $query_result = $this->wpdb->get_result($query_string);

        return $query_result;
    }
}
