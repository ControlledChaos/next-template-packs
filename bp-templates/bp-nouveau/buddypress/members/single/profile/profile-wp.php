<?php
/**
 * BuddyPress - Members Single Profile WP
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

bp_nouveau_wp_profile_hooks( 'before' ); ?>

<div class="bp-widget wp-profile">

	<h2 class="screen-heading"><?php bp_is_my_profile() ? _e( 'My Profile', 'bp-nouveau' ) : printf( __( "%s's Profile", 'bp-nouveau' ), bp_get_displayed_user_fullname() ); ?></h2>

	<?php if ( bp_nouveau_has_wp_profile_fields() ) : ?>

		<table class="wp-profile-fields">

			<?php while ( bp_nouveau_wp_profile_fields() ) : bp_nouveau_wp_profile_field(); ?>

				<tr id="<?php bp_nouveau_wp_profile_field_id();?>">
					<td class="label"><?php bp_nouveau_wp_profile_field_label();?></td>
					<td class="data"><?php bp_nouveau_wp_profile_field_data();?></td>
				</tr>

			<?php endwhile ;?>

		</table>

	<?php else :

		bp_nouveau_user_feedback( 'member-wp-profile-none' );

	endif; ?>

</div>

<?php bp_nouveau_wp_profile_hooks( 'after' ); ?>
