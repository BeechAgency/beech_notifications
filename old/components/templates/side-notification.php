<?php 
    if(!empty($BEECH_sb_options)):
        $image = !empty($BEECH_sb_options['image']) ? $BEECH_sb_options['image'] : false;
?>
<div class="BEECH_notifications BEECH_notifications--side-bar" 
    data-beech-notification-id="<?= $BEECH_sb_options['id'] ?>" 
    data-beech-notification-days="<?= $BEECH_sb_options['days']; ?>"
    data-beech-notification-type="side-bar"
    >
    <div class="BEECH_notifications--side-bar_content">
        <?php if($image !== false): ?><a href="<?php echo $BEECH_sb_options['link']; ?>" class=""><img src="<?= $image ?>" class="BEECH_notifications--side-bar_image" /></a><?php endif;?>
        <div class="BEECH_notifications--side-bar_content--inner">
            <a href="<?php echo $BEECH_sb_options['link']; ?>">
                <h5><?php echo $BEECH_sb_options['title']; ?></h5>
                <p><?php echo $BEECH_sb_options['description']; ?></p>
            </a>
            <!--<a href="<?php echo $BEECH_sb_options['link']; ?>" class="BEECH_notifications--button">Learn More</a>-->
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
<?php 
    endif; ?>
