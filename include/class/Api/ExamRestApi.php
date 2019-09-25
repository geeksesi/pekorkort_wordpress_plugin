<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class ExamRestApi extends ApiBase
{
    /**
     * 
     */
    public function __construct()
    {
        $this->user_api = new UserRestApi();
        global $exam_generator;
        $this->exam_generator = $exam_generator;
    }


    /**
     * must check and return this keys from $_POST
     *  token         [string]
     *  new_only      [boolean]
     *  emptys        [boolean]
     *  wrongs        [boolean]
     *  answer_result [boolean]
     *  random        [boolean]
     *  length        [int]
     *  category      [string]
     *
     * @return boolean|array
     */
    private function check_make_input()
    {
        $output = [];

        if (!isset($_POST['token']) || !isset($_POST['new_only']) || !isset($_POST['emptys']) || !isset($_POST['wrongs']) || !isset($_POST['answer_result']) || !isset($_POST['random']) || !isset($_POST['length']) || !isset($_POST['category']))
            return false;

        if (!empty($_POST['token']) || !empty($_POST['new_only']) || !empty($_POST['emptys']) || !empty($_POST['wrongs']) || !empty($_POST['answer_result']) || !empty($_POST['random']) || !empty($_POST['length']) || !empty($_POST['category']))
            return false;

        $output = [
            (string) "token"         => $_POST["token"],
            (bool)   "new_only"      => $_POST["new_only"],
            (bool)   "emptys"        => $_POST["emptys"],
            (bool)   "wrongs"        => $_POST["wrongs"],
            (bool)   "answer_result" => $_POST["answer_result"],
            (bool)   "random"        => $_POST["random"],
            (int)    "length"        => $_POST["length"],
            (array)  "category"      => json_decode($_POST["category"]),
        ];
        return $output;
    }


    /**
     * check this option with user access
     *
     * @param array $_option
     * @param integer $_user_id
     * @return boolean
     */
    private function check_access_to_option(array $_option, int $_user_id)
    {
        $user_access_code = $this->check_user_access((int) $_user_id);
        if (!$user_access_code) {
            return false;
        }

        return true;
    }

    /**
     * method to handle POST request by this url : `http://localhost/wordpress/wp-json/pekorkort-exam-api/v1/make_exam`
     * a port to make exam 
     *
     * @return string  json endode string
     */
    public function make_exam()
    {
        $inputs = $this->check_make_input();
        if (!is_array($inputs) || !$inputs) {
            $output["ok"]      = false;
            $output["message"] = "inputs faild";
            return json_encode($output);
        }

        $user_id = $this->un_token($_POST["token"]);
        if (!$user_id) {
            $output["ok"]      = false;
            $output["message"] = "User undefined";
            return json_encode($output);
        }

        if (!$this->check_access_to_option($inputs, (int) $user_id)) {
            $output["ok"]      = false;
            $output["message"] = "access denied";
            return json_encode($output);
        }

        $exam_generated = $this->exam_generator($user_id, $inputs);
        if(! $exam_generated)
            return false;

        $output["ok"]      = true;
        $output["message"] = "ok";
        $output["exam"]    = $exam_generated;
        
        return json_encode($output);
    }


    /**
     * check and return this inputs from $_POST
     *  token           [string]
     *  exma_id         [int]
     *  corrects        [JSON/array]
     *  wrongs          [JSON/array]
     *  emptys          [JSON/array]
     *
     * @return boolean|array
     */
    private function check_finish_inputs()
    {
        $output = [];
        if (!isset($_POST["token"]) || !isset($_POST["exam_id"]) || !isset($_POST["corrects"]) || !isset($_POST["wrongs"]) || !isset($_POST["emptys"]))
            return false;

        if (!empty($_POST["token"]) || !empty($_POST["exam_id"]) || !empty($_POST["corrects"]) || !empty($_POST["wrongs"]) || !empty($_POST["emptys"]))
            return false;

        $output = [
            (string) "token"    => $_POST["token"],
            (int)    "exma_id"  => $_POST["exma_id"],
            (array)  "corrects" => json_decode($_POST["corrects"]),
            (array)  "wrongs"   => json_decode($_POST["wrongs"]),
            (array)  "emptys"   => json_decode($_POST["emptys"]),
        ];

        return $output;
    }


    /**
     * must check this user has this exam owner or not
     *
     * @param integer $_user_id
     * @param integer $_exam_id
     * @return boolean
     */
    private function check_exam_and_user(int $_user_id, int $_exam_id)
    {
        return true;
    }


    /**
     * method to handle POST request by this url : `http://localhost/wordpress/wp-json/pekorkort-exam-api/v1/finish_exam`
     * a port to finish exam data 
     *
     * @return string  json endode string
     */
    public function finish_exam()
    {
        $inputs = $this->check_finish_inputs();
        if (!is_array($inputs) || !$inputs) {
            $output["ok"]      = false;
            $output["message"] = "inputs faild";
            return json_encode($output);
        }

        $user_id = $this->un_token($_POST["token"]);
        if (!$user_id) {
            $output["ok"]      = false;
            $output["message"] = "User undefined";
            return json_encode($output);
        }

        if (!$this->check_exam_and_user((int) $user_id, $inputs["exma_id"])) {
            $output["ok"]      = false;
            $output["message"] = "access denied";
            return json_encode($output);
        }
    }
}
