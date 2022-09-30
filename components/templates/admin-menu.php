<?php ?>
<div class="wrap">
		<h1 class="wp-heading-inline">BEECH Notifications Page</h1> 
		<div class="card">
			<p>Hello! Control simple popups and notifications across your site here.<br /> No bloated plugins with endless ads required.</p>
		</div>
	<form method="post" action="options.php">
		<?php settings_fields( 'BEECH-notifications-settings' ); ?>
		<?php do_settings_sections( 'BEECH-notifications-settings' ); ?>
		<div class="tab-list">
			<div class="tab-menu tab">
				<ul>
					<li><button class="tab-link active" onclick="openTab(event, 'BEECH-tab1');" >Side Notification</button></li>
					<li><button class="tab-link" onclick="openTab(event, 'BEECH-tab2');" >Popup / Modal</button></li>
					<li><button class="tab-link" onclick="openTab(event, 'BEECH-tab3');" >Push Notifications</button></li>
					<li id="extrasTab" style="display: none;"><button class="tab-link" onclick="openTab(event, 'BEECH-tab4');" >Extras</button></li>
					<li><?php submit_button(); ?></li>
				</ul>
			</div>
			<div class="tab-body-container">
				<div class="tab-content active" id="BEECH-tab1">	
					<h2>Side Notification</h2>			
					<table class="form-table">
						<tr valign="top">
                            <th>Enable Side Notification<br ><span class="light">Turn this pup on!</span></th>
                            <td>
                                <input type="radio" name="BEECH_notifications--SIDE_BAR__enabled" value="1" <?php checked( '1', get_option( 'BEECH_notifications--SIDE_BAR__enabled' ) ); ?> /> Yes
                                <input type="radio" name="BEECH_notifications--SIDE_BAR__enabled" value="0" <?php checked( '0', get_option( 'BEECH_notifications--SIDE_BAR__enabled' ) ); ?> /> No
                            </td>
                        </tr>
						<tr valign="top">
							<th scope="row">Title<br ><span class="light">Short title for the notification.</span></th>
							<td >
								<div>
									<input type="text" 
										name="BEECH_notifications--SIDE_BAR__title" 
										id="BEECH_notifications--SIDE_BAR__title" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications--SIDE_BAR__title' ); ?>"
										/>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Description<br ><span class="light">Short description for the notification.</span></th>
							<td>
								<div>
									<textarea type="text" 
										name="BEECH_notifications--SIDE_BAR__description" 
										id="BEECH_notifications--SIDE_BAR__description" 
										class="regular-text"
                                        rows="3"
										><?php echo get_option( 'BEECH_notifications--SIDE_BAR__description' ); ?></textarea>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Link<br ><span class="light">Paste the URL you would like to link to</span></th>
							<td>
								<div>
									<input type="text" 
										name="BEECH_notifications--SIDE_BAR__link" 
										id="BEECH_notifications--SIDE_BAR__link" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications--SIDE_BAR__link' ); ?>"
										/>
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Little image<br ><span class="light">Keep it little!</span</th>
							<td >
								<div>
									<img src="<?php echo get_option( 'BEECH_notifications--SIDE_BAR__image' ); ?>" class="BEECH-preview-image" />
									<input type="text" 
										name="BEECH_notifications--SIDE_BAR__image" 
										id="BEECH_notifications--SIDE_BAR__image" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications--SIDE_BAR__image' ); ?>"
										/>
									<input type="button" name="upload-btn1" id="upload-btn1" class="button-secondary" value="Select Image">
								</div>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">ID<br ><span class="light">Change this each time you change the notification.</span></th>
							<td>
								<div>
									<input type="text" 
										name="BEECH_notifications--SIDE_BAR__id" 
										id="BEECH_notifications--SIDE_BAR__id" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications--SIDE_BAR__id' ); ?>"
										/>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="tab-content" id="BEECH-tab2" style="display: none;">
					<h2>Popup / Modal</h2>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Coming soon. <span class="light">Popups will be the next cab off the rank!</span></th>
							<!--<td>
								<div>
									<input type="text" 
										name="BEECH_notifications_screen_primary_color" 
										id="BEECH_notifications_screen_primary_color" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications_screen_primary_color' ); ?>"
										/>
								</div>
							</td>-->
						</tr>
					</table>
				</div>
				<div class="tab-content" id="BEECH-tab3" style="display: none;">
                    <h2>Push Notifications</h2>
					<table class="form-table">
                        <tr valign="top">
							<th scope="row">Push Notifications are coming eventually. <span class="light">They're pretty complex.</span></th>
							<!--<td>
								<div>
									<input type="text" 
										name="BEECH_notifications_display_message_box" 
										id="BEECH_notifications_display_message_box" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications_display_message_box' ); ?>"
										/>
								</div>
							</td>-->
						</tr>
					</table>
				</div>
				<div class="tab-content" id="BEECH-tab4" style="display: none;">
                    <h2>Extra Settings and Sneaky Stuff</h2>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Side Notification Timing <br ><span class="light">How long after this is dismissed should it pop up again in days?</span></th>
							<td>
								<div>
									<input type="text" 
										name="BEECH_notifications--SIDE_BAR__days-dismissed" 
										id="BEECH_notifications--SIDE_BAR__days-dismissed" 
										class="regular-text"
										value="<?php echo get_option( 'BEECH_notifications--SIDE_BAR__days-dismissed' ); ?>"
										/>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>

			
	</form>
</div>