<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @since    1.0.0
 * @version  1.0.0
 *
 * @package BP Nouveau
 */

?>

<div id="cover-image-container">
	<a id="header-cover-image" href="<?php bp_displayed_user_link(); ?>"></a>

	<div id="item-header-cover-image">
		<div id="item-header-avatar">
			<a href="<?php bp_displayed_user_link(); ?>">

				<?php bp_displayed_user_avatar( 'type=full' ); ?>

			</a>
		</div><!-- #item-header-avatar -->

		<div id="item-header-content">

			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
				<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
			<?php endif; ?>

			<div id="item-buttons"><?php bp_nouveau_member_header_buttons(); ?></div><!-- #item-buttons -->

			<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>

			<?php

			/**
			 * Fires before the display of the member's header meta.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_before_member_header_meta' ); ?>

			<div id="item-meta">

				<?php if ( bp_is_active( 'activity' ) ) : ?>

					<div id="latest-update">

						<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>

					</div>

				<?php endif; ?>

				<?php

				 /**
				  * Fires after the group header actions section.
				  *
				  * If you'd like to show specific profile fields here use:
				  * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
				  *
				  * @since 1.2.0
				  */
				 do_action( 'bp_profile_header_meta' );

				 ?>

			</div><!-- #item-meta -->

		</div><!-- #item-header-content -->

	</div><!-- #item-header-cover-image -->
</div><!-- #cover-image-container -->
