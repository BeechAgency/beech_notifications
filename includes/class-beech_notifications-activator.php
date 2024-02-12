<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://github.com/beechagency/
 * @since      1.0.0
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Beech_notifications
 * @subpackage Beech_notifications/includes
 * @author     Beech Agency <hello@beech.agency>
 */
class Beech_notifications_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		/**
		 * Set default settings and create the post type for notifications
		 */
		//$this->setup_default_settings();
	}

	/*
	private static function setup_default_settings() {
		// Define your default options
		$default_options = array(
			'beech_notifications_is_active' => 0
			// Add more options as needed
		);

		// Loop through default options and add them if they don't exist
		foreach ($default_options as $option_name => $default_value) {
			if (get_option($option_name) === false) {
				add_option($option_name, $default_value);
			}
		}

		return true;
	}
	*/
}
