<?php
/**
 * Plugin Name: APA Register Newsletter Form
 * Plugin URI: http://aamtaprakashadhikari.com.np
 * Description: This plugin generates news letter for using short code and saves subscriptions to backend database.  Just use short code [aparnf-reg-form] on post or pages.
 * Version: 1.0.0
 * Author:  apa
 * Author URI: http://aamtaprakashadhikari.com.np
 * License: APA
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('aparnf_URL', plugins_url('', __FILE__));
define('aparnf_FOLDER', plugin_dir_path(__FILE__));
wp_enqueue_style('apaorder', aparnf_URL . '/css/style.css', array(), null);
global $wpdb; 
$aparnf_table_prefix = $wpdb->prefix; 
define('aparnf_TABLE_PREFIX', $aparnf_table_prefix);
// function to activate plugin
register_activation_hook(__FILE__,'aparnf_plugin_install'); 
// function to deactivate plugin
register_deactivation_hook(__FILE__ , 'aparnf_plugin_uninstall' ); 
// add table 
function aparnf_plugin_install()
	{
	  global $wpdb;
		$table = aparnf_TABLE_PREFIX."reg_form";
		$schema = "CREATE TABLE $table (
			id INT(10) NOT NULL AUTO_INCREMENT,
			page_title VARCHAR(255) NOT NULL,
			page_url VARCHAR(255) NOT NULL,
			reg_name VARCHAR(255) NOT NULL,
			reg_email VARCHAR(255) NOT NULL,
			total VARCHAR(255) NOT NULL,
			date_time timestamp,
			UNIQUE KEY id (id)
		);";
		$wpdb->query($schema);
	}
// remove table 
function aparnf_plugin_uninstall()
	{
		//remove Table and data
		global $wpdb;
		$table = aparnf_TABLE_PREFIX."reg_form";
		$deletetable = "drop table if exists $table";
		$wpdb->query($deletetable);  
	}
// add short_cut menu 
add_shortcode( 'aparnf-reg-form', 'aparnf_reg_form' );
function aparnf_reg_form( $atts ) 
	{
		$icon_url = aparnf_URL."/images/employee.png";
		$html=require aparnf_FOLDER . 'form.php';				
		 //return $html;
	}
add_action('admin_menu','aparnf_master_menu');  // 'aparnf_master_menu' would be called  
function aparnf_master_menu() 
	{ 
		if (function_exists('add_menu_page')) {
			add_menu_page(
				"Reg List",
				"Reg List",
				9,
				__FILE__,
				"aparnf_admin_menu_lists",
				aparnf_URL."/images/employee.png"
			); 
			
			add_submenu_page(__FILE__,'Res Summary','Res Summary','9','aparnf_admin_list_data','aparnf_admin_list_data');
			add_submenu_page(__FILE__,'Documentation','Documentation','9','aparnf_admin_documentation','aparnf_admin_documentation');	
		}
	}
function aparnf_admin_menu_lists()
	{
		 require aparnf_FOLDER . 'reg_list.php';
	}
// function to display data
function aparnf_admin_list_data()
	{
		require aparnf_FOLDER . 'reg_summary.php';
	}
function aparnf_admin_documentation()
	{
		require aparnf_FOLDER . 'documentation.php';
	
	}