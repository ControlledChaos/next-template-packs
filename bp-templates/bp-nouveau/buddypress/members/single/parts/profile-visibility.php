<?php
/**
 * BuddyPress - Members Single Profile Edit Field visibility
 *
 * @since  1.0.0
 *
 * @package BP Nouveau
 */

if ( empty( $GLOBALS['profile_template'] ) ) return;
?>

<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>

	<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
		<?php _e('This field may be seen by: ', 'bp-nouveau' ); ?>
			<span class="current-visibility-level">
				<?php printf(__('%s', 'bp-nouveau'), bp_get_the_profile_field_visibility_level_label() ); ?>
			</span>

		<a href="#" class="visibility-toggle-link button"><?php _e( 'Change', 'bp-nouveau' ); ?></a>
	</p>

	<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
		<fieldset>
			<legend><?php _e( 'Who is allowed to see this field?', 'bp-nouveau' ) ?></legend>

			<?php bp_profile_visibility_radio_buttons() ?>

		</fieldset>
		<a class="field-visibility-settings-close button" href="#"><?php _e( 'Close', 'bp-nouveau' ) ?></a>
	</div>

<?php else : ?>

	<p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
		<?php _e('This field may be seen by: ', 'bp-nouveau' ); ?>
		<span class="current-visibility-level">
			<?php printf(__('%s', 'bp-nouveau'), bp_get_the_profile_field_visibility_level_label() ); ?>
		</span>
	</p>

<?php endif ?>
