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
        <input type="radio" name="<?= $setting['key'] ?>" value="1" <?php checked( '1', get_option( $setting['key'] ) ); ?> /> Yes
        <input type="radio" name="<?= $setting['key'] ?>" value="0" <?php checked( '0', get_option( $setting['key'] ) ); ?> /> No
    </td>
</tr>