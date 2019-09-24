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
    }


    /**
     * must check this keys from $_POST
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
            (string) "category"      => $_POST["category"],
        ];
        return $output;
    }


    public function check_access_to_option(array $_option, int $_access_code)
    {
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

        $user_access_code = $this->check_user_access((int) $user_id);

        if (!$user_access_code)
        {
            $output["ok"]      = false;
            $output["message"] = "you has not access to this option";
            return json_encode($output);
        }


        $output["ok"]      = true;
        $output["message"] = "ok";
        return json_encode($output);
    }

    public function finish_exam()
    {
        return "hello world";
    }
}
