<?php
defined('ABSPATH') || exit;

class ExamGenerator
{
    public function __construct()
    {
        global $user_db;
        global $quest_db;
        $this->user_db = $user_db;
        $this->quest_db = $quest_db;
    }


    /**
     * check this value on $_option : 
     *  - new_only      [boolean]
     *  - emptys        [boolean]
     *  - wrongs        [boolean]
     *  - answer_result [boolean]
     *  - random        [boolean]
     *  - length        [int]
     *  - category      [string]
     * 
     * @param array $_option
     * @return boolean
     */
    private function check_option(array $_option)
    {
        if (!is_array($_option))
            return false;

        if (!isset($_option["new_only"]) ||  !isset($_option["emptys"])  ||  !isset($_option["wrongs"])   || !isset($_option["answer_result"]) || !isset($_option["random"]) || !isset($_option["length"]) || !isset($_option["category"]))
            return false;

        if (!is_bool($_option["new_only"]) || !is_bool($_option["emptys"])  || !is_bool($_option["wrongs"]) || !is_bool($_option["answer_result"]) || !is_bool($_option["random"]))
            return false;

        if (!is_int($_option["length"]) || !is_string($_option["category"]))
            return false;

        return true;
    }

    /**
     *
     * @param integer $_user_id
     * @return array
     */
    private function get_user_data(int $_user_id)
    {
        $user_data = $this->user_db->get_by_user_id($_user_id);


        if ($user_data === null) {
            return $this->user_db->set_user($_user_id);
            $user_data = $this->user_db->get_by_user_id($_user_id);
            return $user_data;
        }

        $wrongs_id = $this->str_seprator($user_data["wrongs"]);
        $emptys_id = $this->str_seprator($user_data["emptys"]);

        $user_data["wrongs"] = $wrongs_id;
        $user_data["emptys"] = $emptys_id;

        return $user_data;
    }


    /**
     * 
     *
     * @param string $_categories
     * @return boolean|array
     */
    private function get_more_quest(string $_categories = '')
    {
        if (!is_string($_categories))
            return false;

        if ($_categories === '') {
            return $this->quest_db->get_just_ids();
        }

        $cats = $this->str_seprator($_categories);
        $ids = [];
        foreach ($cats as $key => $cat) {
            $tmp_ids = $this->quest_db->get_by_category($cat);
            $ids = array_merge($ids, $tmp_ids);
        }
        return $ids;
    }

    /**
     * convert ids to data for use
     *
     * @param array $_id_list
     * @param integer $_length
     * @param boolean $_random
     * @return boolean|array
     */
    private function make_useable(array $_id_list, int $_length, bool $_random)
    {
        if (!is_array($_id_list) || !is_int($_length) || !is_bool($_random))
            return false;

        $ids = [];
        if ($_random) {
            $ids = array_rand($_id_list, $_length);
        } else {
            foreach ($_id_list as $key => $value) {
                array_push($ids, $value->id);
                if (sizeof($ids) >= $_length)
                    break;
            }
        }
        $data = $this->quest_db->get_multiple_id($ids);

        return $data;
    }

    /**
     * Undocumented function
     *
     * @param integer $_user_id
     * @param array $_option
     * @return int 
     */
    public function new_exam(int $_user_id, array $_option)
    {
        if (!$this->check_option($_option))
            return false;

        $user = $this->get_user_data($_user_id);

        $quests = [];

        if ($_option["wrongs"] && !$_option["new_only"]) {
            if ($user["wrongs"] !== null && is_array($user["wrongs"])) {
                $quests = array_merge($quests, $user["wrongs"]);
            }
        }

        if ($_option["emptys"] && !$_option["new_only"]) {
            if ($user["emptys"] !== null && is_array($user["emptys"])) {
                $quests = array_merge($quests, $user["emptys"]);
            }
        }

        $more_quest = $this->get_more_quest($_option["category"]);
        if ($more_quest !== null && $more_quest !== false)
            $quests = array_merge($quests, $more_quest);

        $full = $this->make_useable($quests, $_option["length"], $_option["random"]);

        return $full;
    }


    /**
     * seprate string by special char ß
     *
     * @param string|null $_input
     * @return boolean|array
     */
    private function str_seprator($_input)
    {
        if ($_input === null)
            return null;

        if (!is_string($_input))
            return false;

        $char = 'ß';

        $seprated = explode($char, $_input);

        return $seprated;
    }
}
