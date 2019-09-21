<?php
defined('ABSPATH') || exit('No Direct Access.');

require_once(__DIR__ . "/Quest.php");

// add_action('plugins_loaded', 'jal_install');
register_activation_hook(__FILE__, 'jal_install');

global $jal_db_version;
$jal_db_version = '0.1.0';


function jal_install()
{
   error_log("im here");
   global $wpdb;

   $quest = new Quest();
   $table_prefix = $wpdb->prefix;
   $charset_collate = $wpdb->get_charset_collate();

   $quest_sql_query = $quest->migration($table_prefix, $charset_collate);
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   dbDelta($quest_sql_query);
   add_option('jal_db_version', $jal_db_version);
}
