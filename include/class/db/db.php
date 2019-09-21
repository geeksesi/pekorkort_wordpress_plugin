<?php
defined('ABSPATH') || exit('No Direct Access.');

require_once(__DIR__ . "/Quest.php");
require_once(__DIR__ . "/Exam.php");
require_once(__DIR__ . "/Categories.php");


// add_action('plugins_loaded', 'jal_install');

global $jal_db_version;
$jal_db_version = '0.1.0';

$table_prefix     = $wpdb->prefix;

$quest         = new Quest($wpdb, $table_prefix);
$exam          = new Exam($wpdb, $table_prefix);
$categories    = new Categories($wpdb, $table_prefix);

function jal_install()
{
   error_log("im here");
   global $wpdb;
   global $quest;
   global $exam;
   global $categories;
   
   
   $charset_collate  = $wpdb->get_charset_collate();

   $quest_sql_query        = $quest->migration($charset_collate);
   $exam_sql_query         = $exam->migration($charset_collate);
   $categories_sql_query   = $categories->migration($charset_collate);


   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($quest_sql_query);
   dbDelta($exam_sql_query);
   dbDelta($categories_sql_query);
   add_option('jal_db_version', $jal_db_version);
}
