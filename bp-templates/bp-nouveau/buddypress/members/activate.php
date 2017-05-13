<?php
/**
 * BuddyPress - Members Activate
 *
 * @package BuddyPress
 * @subpackage bp-nouveau
 */

?>

	<?php bp_nouveau_activation_hook( 'before', 'page' ); ?>

	<div class="page" id="activate-page">

		<?php bp_nouveau_template_notices(); ?>

		<?php bp_nouveau_activation_hook( 'before', 'content' ); ?>

		<?php if ( bp_account_was_activated() ) : ?>

			<?php if ( isset( $_GET['e'] ) ) : ?>
				<p><?php _e( 'Your account was activated successfully! Your account details have been sent to you in a separate email.', 'bp-nouveau' ); ?></p>
			<?php else : ?>
				<p><?php printf( __( 'Your account was activated successfully! You can now <a href="%s">log in</a> with the username and password you provided when you signed up.', 'bp-nouveau' ), wp_login_url( bp_get_root_domain() ) ); ?></p>
			<?php endif; ?>

		<?php else : ?>

			<p><?php _e( 'Please provide a valid activation key.', 'bp-nouveau' ); ?></p>

			<form action="" method="get" class="standard-form" id="activation-form">

				<label for="key"><?php _e( 'Activation Key:', 'bp-nouveau' ); ?></label>
				<input type="text" name="key" id="key" value="" />

				<p class="submit">
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Activate', 'bp-nouveau' ); ?>" />
				</p>

			</form>

		<?php endif; ?>

		<?php bp_nouveau_activation_hook( 'after', 'content' ); ?>

	</div><!-- .page -->

	<?php bp_nouveau_activation_hook( 'after', 'page' ); ?>

