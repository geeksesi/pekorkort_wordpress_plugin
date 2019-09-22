<?php
defined('ABSPATH') || exit;

require_once(__DIR__ . "/Quest.php");
require_once(__DIR__ . "/Exam.php");
require_once(__DIR__ . "/Categories.php");
require_once(__DIR__ . "/User.php");


// add_action('plugins_loaded', 'jal_install');

global $jal_db_version;
$jal_db_version = '0.1.2';

$table_prefix     = $wpdb->prefix;

$quest_db      = new Quest($wpdb, $table_prefix);
$exam_db       = new Exam($wpdb, $table_prefix);
$categories_db = new Categories($wpdb, $table_prefix);
$user_db       = new User($wpdb, $table_prefix);

function jal_install()
{
   global $wpdb;

   $table_prefix     = $wpdb->prefix;
   $charset_collate  = $wpdb->get_charset_collate();

   $quest_sql_query      = Quest::migration($charset_collate,      $table_prefix);
   $exam_sql_query       = Exam::migration($charset_collate,       $table_prefix);
   $categories_sql_query = Categories::migration($charset_collate, $table_prefix);
   $user_sql_query       = User::migration($charset_collate,       $table_prefix);

   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($quest_sql_query);
   dbDelta($exam_sql_query);
   dbDelta($categories_sql_query);
   dbDelta($user_sql_query);
   add_option('jal_db_version', $jal_db_version);
}
