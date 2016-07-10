<?php
/**
 * BuddyPress - Members Settings Notifications
 *
 * @since  1.0.0
 *
 * @package BP Nouveau
 */

bp_nouveau_member_hook( 'before', 'settings_template' ); ?>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/notifications'; ?>" method="post" class="standard-form" id="settings-form">
	<p><?php _e( 'Send an email notice when:', 'bp-nouveau' ); ?></p>

	<?php bp_nouveau_member_email_notice_settings() ; ?>

	<?php bp_nouveau_submit_button( 'member-notifications-settings' ); ?>

</form>

<?php bp_nouveau_member_hook( 'after', 'settings_template' );
