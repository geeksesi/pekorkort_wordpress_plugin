<?php
defined('ABSPATH') || exit;


class UserRestApi extends ApiBase
{
    public function __construct()
    { }



    public function user_access_handle()
    {
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

        $user_access_code = $this->check_user_access((int) $user_id);

        $output["ok"]      = true;
        $output["message"] = "access full";
        $output["code"]    = $user_access_code;
        return json_encode($output);
    }
}
