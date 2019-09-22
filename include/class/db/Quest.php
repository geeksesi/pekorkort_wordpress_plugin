<?php
defined('ABSPATH') || exit;


class Quest
{
    private $wpdb;
    private $table_name;
    public function __construct($_wpdb, $_prefix)
    {
        $this->table_name = $_prefix . "pekorkort_quest";
        $this->wpdb = $_wpdb;
    }

    /**
     * retun sql query for migration
     *
     * @param   String  $_prefix
     * @param   String  $_charset
     * @return  String  $sql
     */
    public static function migration($_charset, $_prefix)
    {
        $table_name = $_prefix . "pekorkort_quest";
        $sql = "CREATE TABLE $table_name (
            id                int(9)          NOT NULL AUTO_INCREMENT,
            quest             text            NOT NULL,
            answers           text            NOT NULL,
            quest_type        varchar(20)     NOT NULL,
            answers_type      varchar(100)    NOT NULL,
            category_id       int(10)         NOT NULL,
            level             int(2)          NOT NULL,
            wrong_refer       varchar(55)     NOT NULL,
            correct_refer     varchar(55)     NOT NULL,
            timestamp         bigint(12)      NOT NULL,
            
            PRIMARY KEY  (id)
          ) $_charset;";

        return $sql;
    }

    /**
     * set a value 
     *
     * @param string $_question
     * @param string $_answers
     * @param string $_quest_type
     * @param string $_answers_type
     * @param string $_wrong_refer
     * @param string $_correct_refer
     * @param integer $_category_id
     * @param integer $_level
     * @return boolean
     */
    public function set_data(string $_question, string $_answers, string $_quest_type, string $_answers_type, string $_wrong_refer, string $_correct_refer, int $_category_id, int $_level)
    {
        error_log("hey");
        if (empty($_question) || empty($_answers) || empty($_quest_type) || empty($_answers_type) || empty($_wrong_refer) || empty($_correct_refer) || empty($_category_id) || empty($_level))
            return false;

        $query_result = $this->wpdb->insert($this->table_name, [
            "quest" => $_question,
            "answers" => $_answers,
            "quest_type" => $_quest_type,
            "answers_type" => $_answers_type,
            "wrong_refer" => $_wrong_refer,
            "correct_refer" => $_correct_refer,
            "category_id" => $_category_id,
            "level" => $_level,
            "timestamp" => time()
        ], [
            "question" => "%s",
            "answers" => "%s",
            "quest_type" => "%s",
            "answers_type" => "%s",
            "wrong_refer" => "%s",
            "correct_refer" => "%s",
            "category_id" => "%d",
            "level" => "%d",
        ]);

        return $query_result;
    }

    /**
     * get quests id by category id
     *
     * @param integer $_category_id
     * @return boolean|array
     */
    public function get_by_category(int $_category_id)
    {
        if (!is_numeric($_category_id))
            return false;

        $query_string = "SELECT id FROM " . $this->table_name . " WHERE  category_id=" . $_category_id;
        $query_result = $this->wpdb->get_results($query_string);

        return $query_result;
    }


    /**
     * get quests id by deficulty level
     *
     * @param integer $_level
     * @return boolean|array
     */
    public function get_by_level(int $_level)
    {
        if (!is_numeric($_level))
            return false;

        $query_string = "SELECT id FROM " . $this->table_name . " WHERE  level=" . $_level;
        $query_result = $this->wpdb->get_results($query_string);

        return $query_result;
    }

    /**
     * get quest bt id
     *
     * @param integer $_id
     * @return boolean|array
     */
    public function get_by_id(int $_id)
    {
        if (!is_numeric($_id))
            return false;

        $query_string = "SEECT * FROM " . $this->table_name . " WHERE  id=" . $_id;
        $query_result = $this->wpdb->get_row($query_string, ARRAY_A);

        return $query_result;
    }

    /**
     * get all of quests
     *
     * @return array
     */
    public function get_all()
    {
        $query_string = "SELECT * FROM " . $this->table_name;
        $query_result = $this->wpdb->get_results($query_string);

        return $query_result;
    }

    /**
     * get all of quests id
     *
     * @return array
     */
    public function get_just_ids()
    {
        $query_string = "SELECT id FROM " . $this->table_name;
        $query_result = $this->wpdb->get_results($query_string);

        return $query_result;
    }

    /**
     * Undocumented function
     *
     * @param array $_ids
     * @return boolean|array
     */
    public function get_multiple_id(array $_ids)
    {
        if (!is_array($_ids))
            return false;


        $size = sizeof($_ids);
        $where_string = '';
        for ($i = $size - 1; $i >= 0; $i--) {
            if ($i !== 0)
                $where_string .= "id=" . $_ids[$i] . " OR ";
            else
                $where_string .= "id=" . $_ids[$i];
        }

        $query_string = "SELECT * FROM " . $this->table_name . " WHERE " . $where_string;
        error_log($query_string);
        $query_result = $this->wpdb->get_results($query_string);

        return $query_result;
    }
}
