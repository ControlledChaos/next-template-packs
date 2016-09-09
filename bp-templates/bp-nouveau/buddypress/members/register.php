<?php
/**
 * BuddyPress - Members/Blogs Registration forms
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

?>

<div id="buddypress" class="<?php bp_nouveau_buddypress_classes(); ?>">

	<?php bp_nouveau_signup_hook( 'before', 'page' ); ?>

	<div class="page register-page" id="register-page">

		<form action="" name="signup_form" id="signup_form" class="standard-form clearfix" method="post" enctype="multipart/form-data">

			<?php bp_nouveau_template_notices(); ?>

			<?php bp_nouveau_user_feedback( bp_get_current_signup_step() ); ?>

		<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

			<?php bp_nouveau_signup_hook( 'before', 'account_details' ); ?>

			<div class="register-section bp-default" id="basic-details-section">

				<?php /***** Basic Account Details ******/ ?>

				<h2 class="bp-heading"><?php _e( 'Account Details', 'bp-nouveau' ); ?></h2>

				<?php bp_nouveau_signup_form(); ?>

			</div><!-- #basic-details-section -->

			<?php bp_nouveau_signup_hook( 'after', 'account_details' ); ?>

			<?php /***** Extra Profile Details ******/ ?>

			<?php if ( bp_is_active( 'xprofile' ) ) : ?>

				<?php bp_nouveau_signup_hook( 'before', 'signup_profile' ); ?>

				<div class="register-section extended-details" id="profile-details-section">

					<h2 class="bp-heading"><?php _e( 'Profile Details', 'bp-nouveau' ); ?></h2>

					<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
					<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<div<?php bp_field_css_class( 'editfield' ); ?>>

							<?php
							$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
							$field_type->edit_field_html();

							bp_nouveau_xprofile_edit_visibilty();
							?>

							<p class="description"><?php bp_the_profile_field_description(); ?></p>

						</div>

					<?php endwhile; ?>

					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

					<?php endwhile; endif; endif; ?>

					<?php bp_nouveau_signup_hook( '', 'signup_profile' ); ?>

				</div><!-- #profile-details-section -->

				<?php bp_nouveau_signup_hook( 'after', 'signup_profile' ); ?>

			<?php endif; ?>

			<?php if ( bp_get_blog_signup_allowed() ) : ?>

				<?php bp_nouveau_signup_hook( 'before', 'blog_details' ); ?>

				<?php /***** Blog Creation Details ******/ ?>

				<div class="register-section" id="blog-details-section">

					<h2><?php _e( 'Blog Details', 'bp-nouveau' ); ?></h2>

					<p><label for="signup_with_blog"><input type="checkbox" name="signup_with_blog" id="signup_with_blog" value="1"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?> checked="checked"<?php endif; ?> /> <?php _e( 'Yes, I\'d like to create a new site', 'bp-nouveau' ); ?></label></p>

					<div id="blog-details"<?php if ( (int) bp_get_signup_with_blog_value() ) : ?>class="show"<?php endif; ?>>

						<?php bp_nouveau_signup_form( 'blog_details' ); ?>

					</div>

				</div><!-- #blog-details-section -->

				<?php bp_nouveau_signup_hook( 'after', 'blog_details' ); ?>

			<?php endif; ?>

			<?php bp_nouveau_submit_button( 'register' ); ?>

		<?php endif; // request-details signup step ?>

		<?php bp_nouveau_signup_hook( 'custom', 'steps' ); ?>

		</form>

	</div>

	<?php bp_nouveau_signup_hook( 'after', 'page' ); ?>

</div><!-- #buddypress -->
