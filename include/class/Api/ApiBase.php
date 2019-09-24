<?php
defined('ABSPATH') || exit;


class ApiBase
{

    public function __construct()
    { }

    private $HASH_METHOD = 'AES-256-CBC';
    private $KEY         = 'f5eec7ed408c42c1e8dd1e313906efe5';
    private $IV          = 'aea45d7e27dab378b25b76e44a778199';

    /**
     * it's usefull...
     *
     * @param   [type]  $_data  [$_data description]
     *
     * @return  [type]          [return description]
     */
    public function un_hash(string $_data)
    {
        if (!is_string($_data))
            return false;

        $data = base64_decode($_data);
        $json = openssl_decrypt($data, $this->HASH_METHOD, hex2bin($this->KEY), 0, hex2bin($this->IV));
        $data_array = json_decode($json, true);
        return $data_array;
    }


    /**
     * it's just a sample to know how must make an hash from a data
     *
     * @param   [type]  $_data  [$_data description]
     *
     * @return  [type]          [return description]
     */
    public function make_hash(array $_data)
    {
        if (!is_array($_data))
            return false;

        $json = json_encode($_data);
        $data = openssl_encrypt($json, $this->HASH_METHOD, hex2bin($this->KEY), 0, hex2bin($this->IV));
        $hash = base64_encode($data);
        return $hash;
    }



    /**
     * make a token for a user when login
     *
     * @param   [type]  $_user_id  [$_user_id description]
     *
     * @return  [type]             [return description]
     */
    public function make_token(int $_user_id)
    {
        if (!is_int($_user_id))
            return false;

        $array = ["user_id" => $_user_id, "time" => time()];
        return $this->make_hash($array);
    }


    /**
     * extract user_id from token 
     *
     * @param   [type]  $_user_id  [$_user_id description]
     *
     * @return  [type]             [return description]
     */
    public function un_token(string $_token)
    {
        if (!is_string($_token))
            return false;

        $array = $this->un_hash($_token);
        // var_dump($array);
        if (!isset($array["user_id"]))
            return false;

        if (!isset($array["time"]))
            return false;

        if ((int) $array["time"] < time() - 50)
            return false;

        if (!$this->user_validate($array["user_id"]))
            return false;
        // return $this->user_validate(2);
        return (int) $array["user_id"];
    }


    /**
     * check user exist in wordpress or not 
     *
     * @param integer $_user_id
     * @return boolean
     */
    private function user_validate(int $_user_id)
    {
        if (!is_int($_user_id))
            return false;

        $args = [
            'search'         => $_user_id,
            'search_columns' => ['ID']
        ];
        $user_query = new WP_User_Query($args);
        return (empty($user_query->get_results())) ? false : true;
    }


    /**
     * return user access code
     *
     * @param integer $_user_id
     * @return boolean|integer
     */
    public function check_user_access(int $_user_id)
    {
        if (!is_int($_user_id))
            return false;

        return 1;
    }
}
