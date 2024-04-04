<?php
if (__FILE__ == $_SERVER['SCRIPT_FILENAME'] || empty($setting) || empty($group)) {
    // Handle the situation where the template is accessed directly
    var_dump('ERROR');
    die("Don't call this directly fool.");
}
?>

<tr valign="top">
    <th><?= $setting['title'] ?><br ><span class="light"><?= $setting['description'] ?></span></th>
    <td>
        <div>
            <input type="text" 
                name="<?= $setting['key'] ?>" 
                id="<?= $setting['key'] ?>" 
                class="regular-text"
                value="<?php echo get_option(  $setting['key'] ); ?>"
                />
        </div>  
    </td>
</tr>