<?php
defined('ABSPATH') || exit;
include __DIR__ . '/UserApi.php';

/**
 * 
 */
class ExamApi
{
    /**
     * 
     */
    public function __construct()
    {
        $this->user_api = new UserApi();
    }

    public function make_exam($_data)
    {
        return json_encode($_data);
    }

    public function finish_exam($_data)
    {
        return "hello world";
    }
}
