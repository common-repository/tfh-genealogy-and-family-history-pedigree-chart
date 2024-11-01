<?php ob_start(); ?>
<?php
/**
 * Plugin Name: TFH Genealogy and Family History Pedigree Chart
 * Plugin URI: http://thefamilyhistorian.com.au/product/tfh-genealogy-family-history-pedigree-chart/
 * Description: This plugin allows you to add Family History Charts and tables to your Website
 * Author: Warwick Lyons
 * Author URI: http://warwicklyons.com.au
 * Version: 1.0.2
 * License: GPL v2+
 * Text Domain: tfh-pedigree-chart
 * Tags: Genealogy, Family History, Pedigree Chart, Family Tree
 */
 
// Exit the file and scripts if accessed directly from outside WordPress.

if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

function tfh_pedigree_chart_admin_enqueue_scripts(){

	wp_enqueue_script( 'tfh_date-picker-js', plugins_url( 'js/date-picker.js', __FILE__ ), array( 'jquery', 'jquery-ui-datepicker'), '26102016', true );
	
	wp_enqueue_script( 'tfh_living-js', plugins_url( 'js/living.js', __FILE__ ), array( 'jquery'), '26102016', true );
	
	wp_enqueue_script( 'tfh_new-family-js', plugins_url( 'js/new_family.js', __FILE__ ), array( 'jquery'), '26102016', true );
	
	wp_enqueue_script( 'tfh_image-js', plugins_url( 'js/reset_image.js', __FILE__ ), array( 'jquery'), '26102016', true );

	wp_enqueue_style( 'jquery-style', plugins_url( 'css/jquery-ui.css', __FILE__ ) );
	
	wp_enqueue_style( 'tfh-pedigree-admin-css', plugins_url( 'css/admin-style.css', __FILE__ ) );
	
	
	
	/* Call scripts for Media Uploader */

		wp_enqueue_media();

		wp_register_script('media-upload-script', plugins_url( 'js/admin-pedigree-upload.js', __FILE__ ), array( 'jquery'), '26102016', true );
		
    wp_enqueue_script('media-upload-script');
		
		
		wp_enqueue_script('admin-pedigree-upload', plugins_url('/js/admin-pedigree-upload.js'));

		wp_localize_script('admin-pedigree-upload', 'adminPedigreeUpload', array(
    'pluginsUrl' => plugins_url(),
));

	
}

add_action ( 'admin_enqueue_scripts', 'tfh_pedigree_chart_admin_enqueue_scripts');



function tfh_pedigree_chart_front_end(){
	
	 if ( is_plugin_active( 'tfh-genealogy-css/tfh_genealogy_css.php' ) ) {

    return;

  } else {

    wp_enqueue_style( 'tfh-pedigree-front-end-css', plugins_url( 'css/front-end-style.css', __FILE__ ) );

  }

	
	
	/* Call Scripts for Pedigree Chart */

    wp_enqueue_script( 'tfh_javascript-js', plugins_url( 'js/javascript.js', __FILE__ ), array( 'jquery'), '04012017', true );
   
   }

add_action( 'wp_enqueue_scripts', 'tfh_pedigree_chart_front_end' );


// Create the table used in this plugin

function tfh_create_the_chart_table () {
	
  global $wpdb;

  $table_name = $wpdb->prefix . "tfh_pedigree_chart";
   
  $charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(40) NOT NULL,
  last_name VARCHAR(40) NOT NULL,
  sex VARCHAR(10) NOT NULL,
  dob VARCHAR(20) NOT NULL,
  living VARCHAR(20) NOT NULL,
  dod VARCHAR(20) NOT NULL,
  image VARCHAR(200) NOT NULL,
  role VARCHAR(15) NOT NULL,
  further_info TEXT(2000) NOT NULL,
  post_id mediumint(9) NOT NULL,
  family_id VARCHAR(20) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

register_activation_hook( __FILE__, 'tfh_create_the_chart_table' );

// Create the table used in this plugin

function tfh_create_the_child_table () {
	
  global $wpdb;

  $table_name2 = $wpdb->prefix . "tfh_pedigree_children";
   
  $charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name2 (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  parent_id VARCHAR(20) NOT NULL,
  family_link_role VARCHAR(20) NOT NULL,
  child_id VARCHAR(20) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

register_activation_hook( __FILE__, 'tfh_create_the_child_table' );

// Create the marriage table used in this plugin

function tfh_create_the_marriage_table () {
	
  global $wpdb;

  $table_name3 = $wpdb->prefix . "tfh_pedigree_marriage";
   
  $charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $table_name3 (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  person_id VARCHAR(20) NOT NULL,
  marriage_status VARCHAR(20) NOT NULL,
  event_date VARCHAR(20) NOT NULL,
  partner_id VARCHAR(20) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}

register_activation_hook( __FILE__, 'tfh_create_the_marriage_table' );


// CREATE THE MENU SYSTEM


function tfh_create_the_tfh_pedigree_menus () {
	
// Create Top Admin Menu

	define( 'MYPLUGINNAME_PATH', plugin_dir_url(__FILE__));

	$plugin_path = plugin_dir_url(__FILE__);

    add_menu_page( 'Pedigree Chart', 'Pedigree Chart', 'manage_options', 'tfh-familytree-top-menu', 'tfh_create_tfh_updates_and_addons',   $plugin_path.'images/tree2.png');
	
// Stop Top Admin Menu from appearing as a submenu

    add_submenu_page( 'tfh-familytree-top-menu', 'Family Listing', 'Family Listing', 'manage_options', 'add-submenu-family-listing', 'tfh_create_tfh_main_menu');


	  add_submenu_page( 'tfh-familytree-top-menu', 'Add Member', 'Add Family Member', 'manage_options', 'add-submenu-add-new-member', 'tfh_add_new_family_member');

    add_submenu_page( 'tfh-familytree-top-menu', 'Add Ons', 'Add Ons', 'manage_options', 'add-submenu-add-add-ons', 'tfh_add_new_add_ons');

    add_submenu_page( 'tfh-familytree-top-menu', 'Help', 'Help', 'manage_options', 'add-submenu-add-help', 'tfh_add_help');
	
}

add_action('admin_menu', 'tfh_create_the_tfh_pedigree_menus');


//Include Files needed in this Plugin

include('templates/tfh-updates-and-addon.php');

include('templates/tfh-add-new-family-member.php');

include('templates/tfh-add-ons.php');

include('templates/tfh-add-help.php');

include('templates/tfh-main-menu.php');

include('functions/functions.php');

if ( is_plugin_active( 'tfh-genealogy-css/tfh_genealogy_css.php' ) ) { 

return;

} else {

include('shortcodes/shortcodes.php');

}