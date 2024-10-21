<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/beechagency/
 * @since      1.0.0
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/admin
 * @author     Beech Agency <hello@beech.agency>
 */
class Beech_notifications_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $this->set_settings();
		$this->namespace = 'BEECH_notifications--';

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beech_notifications-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beech_notifications-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Setup the admin menu
	 */
	public function register_notifications_menu() {
		$parent_slug = 'tools.php';
	 	$page_title = 'Notifications';   
	 	$menu_title = 'Beech Notifications';   
	 	$capability = 'manage_options';   
	 	$menu_slug  = 'beech_notifications';  
	 	$function   = 'register_admin_page';   
	 	$position   = (int) 10;    

		/**
		 * The admin page for managing the notifications
		*/
		/*
		add_submenu_page( 
			$parent_slug,
			$page_title,                  
			$menu_title,                   
			$capability,                   
			$menu_slug,                   
			array( $this,  'register_admin_display' ),                                 
			$position 
		);
		*/

		/**
		 * The admin page for the settings
		 */
		add_submenu_page( 
			'options-general.php',
			$page_title.' 2',                  
			'Notification Settings',                   
			$capability,                   
			$menu_slug.'_settings',                   
			array( $this,  'register_admin_display' ),                                 
			11
		);
	}


	/**
	 * Setup the CPT
	 */
	public function register_notification_post_type() {

		$labels = [
			'name' => _x( 'Notifications', 'Post Type General Name', 'beech_notifications' ),
			'singular_name' => _x( 'Notification', 'Post Type Singular Name', 'beech_notifications' ),
			'menu_name' => __( 'Notifications', 'beech_notifications' ),
			'name_admin_bar' => __( 'Notifications', 'beech_notifications' ),
			'archives' => __( 'Notifications Archives', 'beech_notifications' ),
			'attributes' => __( 'Notifications Attributes', 'beech_notifications' ),
			'parent_item_colon' => __( 'Parent Notification:', 'beech_notifications' ),
			'all_items' => __( 'Beech Notifications', 'beech_notifications' ),
			'add_new_item' => __( 'Add New Notification', 'beech_notifications' ),
			'add_new' => __( 'Add New', 'beech_notifications' ),
			'new_item' => __( 'New Notification', 'beech_notifications' ),
			'edit_item' => __( 'Edit Notification', 'beech_notifications' ),
			'update_item' => __( 'Update Notification', 'beech_notifications' ),
			'view_item' => __( 'View Notification', 'beech_notifications' ),
			'view_items' => __( 'View Notifications', 'beech_notifications' ),
			'search_items' => __( 'Search Notifications', 'beech_notifications' ),
			'not_found' => __( 'Notification Not Found', 'beech_notifications' ),
			'not_found_in_trash' => __( 'Notification Not Found in Trash', 'beech_notifications' ),
			'featured_image' => __( 'Featured Image', 'beech_notifications' ),
			'set_featured_image' => __( 'Set Featured Image', 'beech_notifications' ),
			'remove_featured_image' => __( 'Remove Featured Image', 'beech_notifications' ),
			'use_featured_image' => __( 'Use as Featured Image', 'beech_notifications' ),
			'insert_into_item' => __( 'Insert into Notification', 'beech_notifications' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Notification', 'beech_notifications' ),
			'items_list' => __( 'Notifications List', 'beech_notifications' ),
			'items_list_navigation' => __( 'Notifications List Navigation', 'beech_notifications' ),
			'filter_items_list' => __( 'Filter Notifications List', 'beech_notifications' ),
		];

		$labels = apply_filters( 'beech_notification-labels', $labels );

		$args = [
			'label' => __( 'Notification', 'beech_notifications' ),
			'description' => __( 'Different kinds of notifications used on your site.', 'beech_notifications' ),
			'labels' => $labels,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			],
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => 'tools.php',
			'menu_slug' => 'notifical',
			'menu_position' => 5,
			'menu_icon' => 'dashicons-calendar',
			'show_in_admin_bar' => false,
			'show_in_nav_menus' => false,
			'exclude_from_search' => true,
			'has_archive' => false,
			'can_export' => false,
			'capability_type' => 'page',
			'show_in_rest' => true,
		];
		$args = apply_filters( 'beech_notification-args', $args );

		register_post_type( 'beech_notification', $args );
		

	}

	/* Disable Guttenberg for it */
	public function disable_gutenberg_for_notifications($current_status, $post_type) { 
		// Disabled post types
    	$disabled_post_types = array( 'beech_notification' );

		// Change $can_edit to false for any post types in the disabled post types array
		if ( in_array( $post_type, $disabled_post_types, true ) ) {
			$current_status = false;
		}

    	return $current_status;
	}


	/*
	 * Add data to the columns to notification list
	 */
	public function add_notification_column_data ( $column, $post_id ) {
		switch ( $column ) {
			case 'enabled':
				echo ucfirst(get_post_meta($post_id, $this->namespace.'_enabled', true));
				break;
			case 'type':
				echo ucfirst(get_post_meta($post_id, $this->namespace.'_type', true));
				break;
			case 'end_date':
				$dateFormat = get_option('date_format');
				$timeFormat = get_option('time_format');
				$dateString = get_post_meta($post_id, $this->namespace.'_end_date', true);
				$formattedDate = date_i18n($dateFormat.' '.$timeFormat, strtotime($dateString));

				echo $formattedDate;
			break;
		}
	}

	/*
	* Add columns to post list
	*/
	public function add_notification_columns ( $columns ) {
		$newColumns = array(
			'enabled' => __('Enabled'),
			'type' => __('Type'),
			'end_date' => __('End Date')
		);

		$existingProperty = 'date'; // Replace 'tags' with the property key before which you want to insert

		if (array_key_exists($existingProperty, $columns)) {
			// Get the position of the existing property in the array
			$insertPosition = array_search($existingProperty, array_keys($columns));

			// Split the original array into two parts at the insertion point
			$columnsBeforeInsertion = array_slice($columns, 0, $insertPosition, true);
			$columnsAfterInsertion = array_slice($columns, $insertPosition, null, true);

			// Merge the parts of the array with the new properties inserted in between
			$columns = $columnsBeforeInsertion + $newColumns + $columnsAfterInsertion;
		} else {
			// If the existing property doesn't exist, simply merge the new properties at the end
			$columns = array_merge($columns, $newColumns);
		}

		return $columns;
	}
		


	// Add meta boxes and fields for the notification post type
	public function add_notification_meta_boxes() {
		add_meta_box(
			'notification_meta_box',
			'Notification Settings',
			array( $this, 'render_notification_meta_box'),
			'beech_notification', // Replace with your custom post type slug
			'side',
			'default'
		);

		
	}

	// Save callback for the notification meta box
	function save_notification_meta_box($post_id) {
		// Verify nonce
		if (!isset($_POST['notification_nonce']) || !wp_verify_nonce($_POST['notification_nonce'], 'notification_meta_box_nonce')) {
			return $post_id;
		}

		// Check if this is an autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// Check user permissions
		if (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		// Save custom field values
		update_post_meta($post_id, $this->namespace.'_enabled', isset($_POST['enabled']) ? 'on' : 'off');
		update_post_meta($post_id, $this->namespace.'_end_date', sanitize_text_field($_POST['end_date']));
		update_post_meta($post_id, $this->namespace.'_type', sanitize_text_field($_POST['type']));
		update_post_meta($post_id, $this->namespace.'_pages', sanitize_textarea_field($_POST['pages']));
		update_post_meta($post_id, $this->namespace.'_cta_text', sanitize_text_field($_POST['cta_text']));
		update_post_meta($post_id, $this->namespace.'_cta_link', sanitize_text_field($_POST['cta_link']));
	}


	// Render callback for the notification meta box
	public function render_notification_meta_box($post) {
		// Retrieve existing values from the database
		$enabled = get_post_meta($post->ID, $this->namespace.'_enabled', true);
		$cta_text = get_post_meta($post->ID, $this->namespace.'_cta_text', true);
		$cta_link = get_post_meta($post->ID, $this->namespace.'_cta_link', true);
		$end_date = get_post_meta($post->ID, $this->namespace.'_end_date', true);
		$type = get_post_meta($post->ID, $this->namespace.'_type', true);
		$pages = get_post_meta($post->ID, $this->namespace.'_pages', true);

		// Nonce field to verify the submission
		wp_nonce_field('notification_meta_box_nonce', 'notification_nonce');

		// Output fields
		?>
		
		<label for="enabled" class="BN__checkbox">
			<input type="checkbox" name="enabled" id="enabled" <?php checked($enabled, 'on'); ?> />
			<span>Enable Notification</span>
		</label>
		<br>
		<label for="cta_text" class="BN__input">
			<span>CTA Text</span>
			<input type="text" name="cta_text" id="cta_text" value="<?php echo $cta_text; ?>" />
		</label>
		<br>
		<label for="cta_link" class="BN__input">
			<span>CTA Link</span>
			<input type="text" name="cta_link" id="cta_link" value="<?php echo $cta_link; ?>" />
		</label>
		<br>
		<label for="end_date" class="BN__input">
			<span>End Date:</span>
			<input type="datetime-local" name="end_date" id="end_date" value="<?php echo esc_attr($end_date); ?>" />
		</label>
		<br>
		<label for="type" class="BN__input">
			<span>Type:</span>
			<select name="type" id="type">
				<option value="right_corner" <?php selected($type, 'right_corner'); ?>>Right Corner</option>
				<option value="popup" <?php selected($type, 'popup'); ?>>Popup</option>
				<option value="top_bar" <?php selected($type, 'top_bar'); ?>>Top Bar</option>
				<option value="toast" <?php selected($type, 'toast'); ?>>Toast</option>
				<option value="push" <?php selected($type, 'push'); ?>>Push</option>
			</select>
		</label>
		<br>
		<label for="pages" class="BN__input BN__tags-input-container" >
			<span>Pages:</span>

			<div class="BN__tags-input-group">
				<div class="BN__tags-input-el">
					<input class="BN__tags-input" placeholder="/page-slug" type="text">
					<button>+</button>
				</div>
				<span class="BN__hint-text">Press the plus to add page to list</span>
				<div class="BN__tags-display"></div>
			</div>
			<template class='BN__tag_template'>
				<div class="BN__tag"><span>Tag</span> <button class="BN__tag-close">+</button></div>
			</template>
			<textarea class="BN__tags-hidden-input" name="pages" id="pages" rows="1"><?php echo esc_textarea($pages); ?></textarea>
		</label>
		

		<?php
	}

	public function set_settings() {
		return array(
			array(
				'title' => 'Disable All Notifications',
				'key' => 'BEECH_notifications--SETTING__disabled',
				'description' => 'Turn off all notifications immediately. Hard stop on everything.',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Config'
			),
			array(
				'title' => 'Testing Mode',
				'key' => 'BEECH_notifications--SETTING__testing-mode',
				'description' => 'Only display notifications for logged in users.',
				'default' => 0,
				'type' => 'boolean',
				'group' => 'Config'
			),
			array(
				'title' => 'Notification Text Color',
				'key' => 'BEECH_notifications--SETTING__color-text',
				'description' => 'Primary text color',
				'default' => '#000000',
				'type' => 'color',
				'group' => 'Display'
			),
			array(
				'title' => 'Notification Background Color',
				'key' => 'BEECH_notifications--SETTING__color-background',
				'description' => 'Primary background color',
				'default' => '#ffffff',
				'type' => 'color',
				'group' => 'Display'
			),
			array(
				'title' => 'Notification Accent Color',
				'key' => 'BEECH_notifications--SETTING__color-accent',
				'description' => 'Color of the accents, different for each notification type.',
				'default' => '#EDF060',
				'type' => 'color',
				'group' => 'Display'
			),
			array(
				'title' => 'Default width',
				'key' => 'BEECH_notifications--SETTING__display-width',
				'description' => 'Default width for notifications that are not 100% wide.',
				'default' => '20rem',
				'type' => 'text',
				'group' => 'Display'
			),
			array(
				'title' => 'Custom CSS',
				'key' => 'BEECH_notifications--SETTING__custom-css',
				'description' => 'Add your custom styles here!',
				'default' => '',
				'type' => 'textarea',
				'group' => 'Display'
			)
		);
	}

	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Setup the settings
	 */
	public function register_settings() {
		
		foreach($this->settings as $setting) {
			register_setting( 
				'beech_notifications_settings', 
				$setting['key'], 
				array(
					'default' => $setting['default'],
					'description' => $setting['description'],
					'type' => $setting['type']
				) 
			);
		}
		
	}

	/**
	 * Register admin page
	 */
	public function register_admin_display() {
		include_once 'partials/beech_notifications-admin-display.php';
	}



	/**
	 * Set GForm button for Notificaion WYSIWYG pages
	 * @since 1.3
	 * 
	 */
	public function display_gform_button(  $display_add_form_button  ) {
		global $current_screen;


		if(!empty($current_screen) && $current_screen->post_type == 'beech_notification') {

			/*
			echo '<pre style="position:fixed; background-color:red; z-index: 100000; left: 0; top: 0;" id="pre">';
			var_dump($current_screen->post_type);
			var_dump('YOLO');
			echo '</pre>';
			*/

			return true;
		} else {
			return $display_add_form_button;
		}

	}
}