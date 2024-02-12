<?php
/**
 * Template for a notification
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://https://github.com/beechagency/
 * @since      1.0.0
 *
 * @package    Beech_notifications
 * @subpackage Beech_notifications/public/partials
 */
?>
<template id="BEECH_notifications--right_corner">
    <div class="BEECH_notification BEECH_notifications--right_corner" 
        data-beech-notification-id="" 
        data-beech-notification-days="90"
        data-beech-notification-type="right_corner"
        >
        <div class="BEECH_notifications--right_corner_content">
            <a href="#" class="BEECH_notifications--link"><img src="" class="BEECH_notifications--image BEECH_notifications--right_corner_image" /></a>
            <div class="BEECH_notifications--right_corner_content--inner">
                <a href="#" class="BEECH_notifications--link">
                    <h5 class="BEECH_notifications--title"></h5>
                    <div class="BEECH_notifications--content"></div>
                </a>
                <a href="#" class="BEECH_notifications--button">Learn More</a>
                <a href="#" class="BEECH_notifications--close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g id="Group_511" data-name="Group 511" transform="translate(-910 -907)">
                            <circle id="Ellipse_10" data-name="Ellipse 10" cx="12" cy="12" r="12" transform="translate(910 907)" fill="var(--icon--accent)"/>
                            <g id="Group_510" data-name="Group 510" transform="translate(-286.623 822.944)">
                                <path id="Path_474" data-name="Path 474" d="M0,0H12.734" transform="translate(1204.121 91.554) rotate(45)" fill="none" stroke="var(--icon--color)" stroke-width="1.5"/>
                                <path id="Path_477" data-name="Path 477" d="M0,0H12.734" transform="translate(1213.125 91.554) rotate(135)" fill="none" stroke="var(--icon--color)" stroke-width="1.5"/>
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>