<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME'] || empty($settings) || empty($group) || empty( $group_index )) {
    // Handle the situation where the template is accessed directly
    die("Access denied");
}
?>
    <div class="tab-content <?= $group_index > 1 ? 'active' : ''; ?>" id="BEECH-tab<?= $group_index ?>" style="<?= $group_index > 1 ? 'display: none' : '';?>">	
        <h2><?= $group ?></h2>			
        <table class="form-table">
            <?php foreach($settings as $setting): 
                    if($setting['group'] !== $group) continue; 

                    $type  = $setting['type'];

		            include plugin_dir_path( __FILE__ ) . "/inputs/beech_notifications-admin__input-$type.php";

                endforeach;?>
        </table>
    </div>