<?php
defined('ABSPATH') || exit('No Direct Access.');

require_once(__DIR__ . "/Quest.php");
require_once(__DIR__ . "/Exam.php");
require_once(__DIR__ . "/Categories.php");


// add_action('plugins_loaded', 'jal_install');

global $jal_db_version;
$jal_db_version = '0.1.0';


function jal_install()
{
   error_log("im here");
   global $wpdb;

   $quest         = new Quest($wpdb);
   $exam          = new Exam($wpdb);
   $categories    = new Categories($wpdb);

   $table_prefix     = $wpdb->prefix;
   $charset_collate  = $wpdb->get_charset_collate();

   $quest_sql_query        = $quest->migration($table_prefix, $charset_collate);
   $exam_sql_query         = $exam->migration($table_prefix, $charset_collate);
   $categories_sql_query   = $categories->migration($table_prefix, $charset_collate);


   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($quest_sql_query);
   dbDelta($exam_sql_query);
   dbDelta($categories_sql_query);
   add_option('jal_db_version', $jal_db_version);
}
