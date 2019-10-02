<?php
defined('ABSPATH') || exit;


class CategpriesRestApi extends ApiBase
{
    public function __construct()
    {
        global $categories_db;
        $this->categories_db = $categories_db;
    }



    public function category_request_handle()
    {
        // return $_POST;
        // return $this->make_token(1);
        $output = [];
        if (!isset($_POST["token"]) || !is_string($_POST["token"])) {
            $output["ok"]      = false;
            $output["message"] = "token undefined";
            return json_encode($output);
        }

        $user_id = $this->un_token($_POST["token"]);
        if (!$user_id) {
            $output["ok"]      = false;
            $output["message"] = "User undefined";
            return json_encode($output);
        }

        $categories = $this->categories_db->get_all();

        $output["ok"]      = true;
        $output["data"]    = $categories;
        return json_encode($output);
    }
}
