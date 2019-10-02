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

        if (!is_int($_option["length"]) || !is_array($_option["category"]))
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
        $seens_id  = $this->str_seprator($user_data["seens"]);

        $user_data["wrongs"] = ($wrongs_id === null) ? [] : $wrongs_id;
        $user_data["emptys"] = ($emptys_id === null) ? [] : $emptys_id;
        $user_data["seens"]  = ($seens_id  === null) ? [] : $seens_id;

        return $user_data;
    }


    /**
     * 
     *
     * @param array $_categories
     * @return boolean|array
     */
    private function get_more_quest(array $_categories = [])
    {
        if (!is_array($_categories))
            return false;

        if (empty($_categories)) {
            return $this->quest_db->get_just_ids();
        }

        $cats = $_categories;
        $ids = [];
        foreach ($cats as $key => $cat) {
            $tmp_ids = $this->quest_db->get_by_category($cat);
            $ids = array_merge($ids, $tmp_ids);
        }
        return $ids;
    }

    /**
     * set limit or random on question ids
     *
     * @param array $_id_list
     * @param integer $_length
     * @param boolean $_random
     * @return boolean|array
     */
    public function clean_ids(array $_id_list, int $_length, bool $_random)
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
        return $_id_list;

    }


    /**
     * store exam generated on db
     *
     * @param  integer $_user_id
     * @param  array   $_option
     * @param  array   $_quests_id
     * @return boolean
     */
    public function store_exam(int $_user_id, array $_option, array $_quests_id)
    {
        global $exam_db;
        $option = json_encode($_option);
        $questions_id = json_encode($_quests_id);

        $store_result = $exam_db->set_data($_user_id,  $questions_id, $option);
        return $store_result;
    }



    /**
     * get ids of not duplicates
     *
     * @param  array $_seens
     * @param  array $_all
     * @return boolean|array
     */
    private function get_just_new(array $_seens, array $_all)
    {
        if (!is_array($_seens) || !is_array($_all))
            return false;

        $sees_id = [];
        foreach ($_seens as $key => $value) {
            $sees_id[$key]["id"] = $value["id"];
        }

        $result = array_merge(
            array_diff(array_map('serialize', $_all), array_map('serialize', $sees_id)),
            array_diff(array_map('serialize', $sees_id), array_map('serialize', $_all))
        );

        return array_map('unserialize', $result);
    }



    /**
     * Undocumented function
     *
     * @param integer $_user_id
     * @param array $_option
     * @return boolean|array 
     */
    public function new_exam(int $_user_id, array $_option)
    {
        if (!$this->check_option($_option))
            return false;

        $user   = $this->get_user_data($_user_id);

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
        
        if ($_option["new_only"])
        $quests = $this->get_just_new($user["seens"], $quests);
        
        $final_ids = $this->clean_ids($quests, $_option["length"], $_option["random"]);
        // return $final_ids;
        if (!$final_ids)
        return false;

        $exam_id = $this->store_exam($_user_id, $_option, $final_ids);
        $full = $this->quest_db->get_multiple_id($final_ids);

        return [
            "exam_id" => $exam_id,
            "quests"  => $full
        ];
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
