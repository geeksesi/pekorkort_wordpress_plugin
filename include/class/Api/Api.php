<?php
defined('ABSPATH') || exit;
include __DIR__ . '/ApiBase.php';
include __DIR__ . '/UserRestApi.php';
require __DIR__ . '/ExamRestApi.php';
require __DIR__ . '/CategoriesRestApi.php';


add_action('rest_api_init', 'make_route');


function make_route()
{
    $exam_api       = new ExamRestApi();
    $user_api       = new UserRestApi();
    $categories_api = new CategpriesRestApi();
    
    register_rest_route('pekorkort-exam-api/v1', 'user_access', array(

        'methods'  => 'POST',
        'callback' => [&$user_api, 'user_access_handle']

    ));


    register_rest_route('pekorkort-exam-api/v1', 'make_exam', array(

        'methods'  => 'POST',
        'callback' => [&$exam_api, 'make_exam']

    ));


    register_rest_route('pekorkort-exam-api/v1', 'finish_exam', array(

        'methods'  => 'POST',
        'callback' => [&$exam_api, 'finish_exam']

    ));


    register_rest_route('pekorkort-exam-api/v1', 'get_categories', array(

        'methods'  => 'POST',
        'callback' => [&$categories_api, 'category_request_handle']

    ));
}

//get_current_user_id()
