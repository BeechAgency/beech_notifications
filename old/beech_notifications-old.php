<?php
/**
 * Plugin Name: BEECH Notifications
 * Plugin URI: https://beech.agency
 * Description: Gives you some sweet sweet notifications
 * Version: 0.1
 * Author: BEECH Agency
 * Author URI: https://beech.agency
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if( ! class_exists( 'BEECH_Updater' ) ){
	include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}

$updater = new BEECH_Updater( __FILE__ );
$updater->set_username( 'BeechAgency' );
$updater->set_repository( 'beech_notifications' );
/*
	$updater->authorize( 'abcdefghijk1234567890' ); // Your auth code goes here for private repos
*/
$updater->initialize();

 // Set up settings
if( !function_exists("BEECH_notifications_init") ) { 
	function BEECH_notifications_init() {   
		/* Sidebar Notifications Settings */
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__enabled' );
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__title' );
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__description' );
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__image' );
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__link' );
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__id' );
		register_setting( 'BEECH-notifications-settings', 'BEECH_notifications--SIDE_BAR__days-dismissed' );
	}
}

// Set up menu
function BEECH_notifications_admin_menu() {
	 $parent_slug = 'tools.php';
	 $page_title = 'Beech Notifications';   
	 $menu_title = 'Beech Notifications';   
	 $capability = 'manage_options';   
	 $menu_slug  = 'beech-notifications';  
	 $function   = 'BEECH_notifications_admin_page';   
	 $icon_url   = 'dashicons-bell';   
	 $position   = (int) 10;    

	 add_submenu_page( 
		 $parent_slug,
		 $page_title,                  
		 $menu_title,                   
		 $capability,                   
		 $menu_slug,                   
		 $function,                                 
		 $position 
	); 
	add_action( 'admin_init', 'BEECH_notifications_init' ); 
}

add_action( 'admin_menu', 'BEECH_notifications_admin_menu' );  


require_once('components/beech_notifications-admin-page.php');
require_once('components/beech_notifications-side-notification.php');
/*
require 'components/beech_login-login-page.php';
require 'components/beech_login-messages.php';
*/