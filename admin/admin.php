<?php
add_action('admin_menu', 'PekorKort_admin_menu');

function PekorKort_admin_menu(){

	$main = add_menu_page(__('PEKORKORT', 'PekorKort-wp'), __('PEKORKORT', 'PekorKort-wp'), 'manage_options', 'PekorKort_dashboard', 'PekorKort_dashboard_page', PEKORKORT_IMG_URL."logo.svg");

	$main_sub = add_submenu_page('PekorKort_dashboard', __('PEKORKORT', 'PekorKort-wp'), __('PEKORKORT', 'PekorKort-wp'), 'manage_options', 'PekorKort_dashboard');

}

function PekorKort_dashboard_page ()
{
    // global $BTC;
    require PEKORKORT_TPL_DIR.'html-admin-main.php';
}