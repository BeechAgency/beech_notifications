<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://github.com/beechagency/
 * @since      1.0.0
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/public
 * @author     Beech Agency <hello@beech.agency>
 */
class Beech_notifications_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $this->get_settings();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Beech_notifications_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Beech_notifications_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beech_notifications-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Beech_notifications_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Beech_notifications_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beech_notifications-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Get the dang notificatiosn and outoput as JSON
	 */
	private function get_active_notifications() {
		$args = array(
			'post_type'      => 'beech_notification', // Replace with your custom post type slug
			'post_status'    => 'publish',
			'meta_query'     => array(
				array(
					'key'   => '_enabled',
					'value' => 'on', // Assuming 'on' is the value for enabled
				),
				/*
				array(
					'key'   => '_end_date',
					'value' => 'on', // Assuming 'on' is the value for enabled
				),*/
			),
		);

		$notification_query = new WP_Query($args);

		$notifications = array();
		$cookie_array = array();

		$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


		if (isset($_COOKIE['BEECH_notifications'])) {
			$cookie_value =  $_COOKIE['BEECH_notifications'];
			$cookie_value =  rtrim($cookie_value, ',');

			$cookie_array =  explode(',', $cookie_value);
			//$notifications[] = $cookie_array;
		}

		if ($notification_query->have_posts()) {
			while ($notification_query->have_posts()) {
				$notification_query->the_post();

				$ID = get_the_ID();
				$end_date = get_post_meta( get_the_ID(), '_end_date', true );

				// Create a DateTime object from the date string
				$end_date_time = new DateTime($end_date);

				// Get the current date and time
				$current_date_time = new DateTime();

				if (
					($end_date_time > $current_date_time) &&
					 !in_array($ID, $cookie_array) 
					) { 

					$pages = get_post_meta( get_the_ID(), '_pages', true );
					$pages = str_replace("\r", "", $pages); // Clean up the carriage returns.

					if (strpos($pages, "\n") !== false) {
						$pagesArray = explode("\n",$pages);
					} else {
						$pagesArray = array();
					}

					//$notifications[] = $pagesArray;

					if( 
						in_array($current_path, $pagesArray) || 
						count($pagesArray) === 0 
						) {
 
						// The end date is in the future!!!
						$notification = array(
							'ID' => $ID,
							'title' => get_the_title(),
							'content' => apply_filters('the_content', get_the_content()),
							'image' => get_the_post_thumbnail_url(),
							'end_date' => $end_date,
							'type' => get_post_meta( get_the_ID(), '_type', true ),
							'pages' => $pagesArray,
							'cta_text' => get_post_meta( get_the_ID(), '_cta_text', true ),
							'cta_link' => get_post_meta( get_the_ID(), '_cta_link', true ),
						);

						$notifications[] = $notification;

					}
				}
				
			}

			// Restore original post data
			wp_reset_postdata();
		}

		//$notifications_json = wp_json_encode( $notifications  );
		return $notifications;

	}

	/**
	 * Get the settings values
	 */
	private function get_settings() {

		$settings = array();

		$settings['is_disabled'] =  get_option( 'BEECH_notifications--SETTING__disabled' );
		$settings['is_testmode'] =  get_option('BEECH_notifications--SETTING__testing-mode' );
		$settings['color-text'] =  get_option('BEECH_notifications--SETTING__color-text' );
		$settings['color-background'] =  get_option('BEECH_notifications--SETTING__color-background' );
		$settings['color-accent'] =  get_option('BEECH_notifications--SETTING__color-accent' );
		$settings['display-width'] =  get_option('BEECH_notifications--SETTING__display-width' );

		return $settings;
	}

	/**
	 * Generate CSS styles string
	 */
	private function make_css_from_settings() {
		$css = '.BEECH_notifications {';

		!empty($this->settings['color-text']) ? $css .= '--bch-sn--color: '. $this->settings['color-text'] .';' : ''; 
		!empty($this->settings['color-accent']) ? $css .= '--bch-sn--accent: '. $this->settings['color-accent']  .';': ''; 
		!empty($this->settings['color-background']) ? $css .= '--bch-sn--background: '. $this->settings['color-background']  .';': ''; 
		!empty($this->settings['display-width']) ? $css .= '--bch-sn--width: '. $this->settings['display-width'] .';' : ''; 

		$css .= '};';

		return $css;
	}

	/**
	 * Output the JSON to the frontend
	 */
	 public function output_active_notifications() {
		$notifications = $this->get_active_notifications();
		$notifications_json = wp_json_encode( $notifications  );

		$not_testmode = true;

		if($this->settings['is_testmode']) {
			$not_testmode = false;
			$user_logged_in = is_user_logged_in();

			if($user_logged_in) $not_testmode = true;
		}


		if(count($notifications) > 0 && !$this->settings['is_disabled'] && $not_testmode) {
			echo '<style type="text/css">';
			echo $this->make_css_from_settings();
			echo '</style>';
			echo '<script type="text/javascript">';
			echo "const BEECH_notifications_data = $notifications_json";
			echo '</script>';
			echo '<div class="BEECH_notifications"></div>';

			// @TODO - only output the templates that are required.
			echo '<div class="BEECH_notifications_templates">';
			include plugin_dir_path(__FILE__) . 'partials/beech_notifications-template--right_corner.php';
			include plugin_dir_path(__FILE__) . 'partials/beech_notifications-template--popup.php';
			include plugin_dir_path(__FILE__) . 'partials/beech_notifications-template--toast.php';
			include plugin_dir_path(__FILE__) . 'partials/beech_notifications-template--top_bar.php';
			echo '</div>';

		}
	}
}
