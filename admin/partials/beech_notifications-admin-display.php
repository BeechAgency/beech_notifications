<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://https://github.com/beechagency/
 * @since      1.0.0
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/admin/partials
 */


$settings = $this->settings;
$groups = array();
?>

<div class="wrap">
    <h1 class="wp-heading-inline">BEECH Notification Settings</h1> 
    <div class="card">
        <p>Hello! The BEECH Notification settings are here.<br /> No bloated plugins with endless ads required.</p>
    </div>
	<form method="post" action="options.php">
		<?php settings_fields( 'beech_notifications_settings' ); ?>
		<?php do_settings_sections( 'beech_notifications_settings' ); ?>
		<div class="tab-list">
			<div class="tab-menu tab">
                <?php 
                if(!empty($settings)):
                    echo '<ul>';
                    $is_active = 'active';
                    $group_index = 1;

                    foreach($settings as $setting): 
                         if (!in_array($setting["group"], $groups)) {
                            // Add the group name to the $groups array
                            $group = $setting['group'];
                            $groups[] = $setting["group"];
                            ?>
                            <li><button class="tab-link <?= $is_active ?>" onclick="openTab(event, 'BEECH-tab<?= $group_index ?>');" ><?= $group ?></button></li>
                            <?php
                            $group_index += 1;
                         }
                         $is_active = '';
                    endforeach; 

                    echo "<li>";
                    submit_button();
                    echo "</li>";
                    echo '</ul>';
                endif;    
                ?>
			</div>
			<div class="tab-body-container">
                <?php 
                    if(!empty($groups)):
                        $group_index = 1;
                        foreach($groups as $group):

		                    include plugin_dir_path( __FILE__ ) . '/beech_notifications-admin-display__group.php';

                            $group_index += 1;
                        endforeach;
                    endif;
                ?>
			</div>
	</form>
</div>