<?php
/**
 * BuddyPress  Main Component Directory Navigation
 *
 * @since 1.0.0
 *
 * @package BP Next
 */

$component = bp_current_component();
switch($component) {
	case 'groups' :
	 $component_name      = $component;
		$component_permalink = bp_get_groups_directory_permalink();
		$component_count     = '<span class="comp-counts">' . bp_get_total_group_count() . '</span>';
		$user_comp_count     = bp_get_total_group_count_for_user( bp_loggedin_user_id() );
		$my_comp_count       = '<span class="my-' .$component . '-count">' . $user_comp_count  . '</span>';
		$user_account_comp_link = bp_loggedin_user_domain() . bp_get_groups_slug() . '/my-groups/';
		$personal_items = ( $user_comp_count )? true : false ;
	break;

	case 'members' :
		$component_name      = __('Friends', 'bp-nouveau');
		$component_permalink = bp_get_members_directory_permalink();
		$component_count     = bp_get_total_member_count();
		$friend_count        = bp_get_total_friend_count( bp_loggedin_user_id() );
		$my_comp_count       = '<span class="my-friends-count">' . $friend_count  . '</span>';
		$user_account_comp_link = bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/';
		$personal_items  = ( bp_is_active( 'friends' ) && $friend_count ) ? true : false;
	break;

	case 'blogs' :
		$component_name      = __( 'Sites', 'bp-nouveau' );
		$component_permalink = bp_get_root_domain() . '/' .  bp_get_blogs_root_slug();
		$component_count     = bp_get_total_blog_count();
		$my_blog_count       = bp_get_total_blog_count_for_user( bp_loggedin_user_id() );
		$my_comp_count       = '<span class="my-blogs-count">' . $my_blog_count  . '</span>';
		$user_account_comp_link = bp_loggedin_user_domain() . bp_get_blogs_slug() ;
		$personal_items   = ( $my_blog_count ) ? true : false;
	break;

	case 'activity' :
		$component_name          = $component;
		$component_count         = '';
		$component_permalink     = bp_get_activity_directory_permalink();
		$my_account_friends_link = bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_friends_slug() . '/';
		$friend_count            = bp_get_total_friend_count( bp_loggedin_user_id() );
		$my_comp_count           = '<span class="my-friends-count">' . $friend_count  . '</span>';
		$my_fav_count     = bp_get_total_favorite_count_for_user( bp_loggedin_user_id() ) ;
		$user_account_comp_link = bp_loggedin_user_domain() . bp_get_friends_slug() . '/my-friends/';
		// Too many variences this doesn't work now as activity has personal groups and friends.
		$personal_items_groups  = ( bp_is_active( 'groups' ) && $friend_count ) ? true : false;
		$my_groups_count = bp_get_total_group_count_for_user( bp_loggedin_user_id() );
	break;

}
?>

<menu type="list" class="component-navigation <?php echo $component; ?>-nav">

		<li class="selected" id="<?php echo $component; ?>-all" data-bp-scope="all" data-bp-object="<?php echo $component; ?>">
			<a href="<?php echo $component_permalink; ?>">
				<?php printf( __( 'All %1$s %2$s', 'bp-nouveau' ), $component, $component_count ); ?>
			</a>
		</li>

		<?php if ( is_user_logged_in() ) : ?>

			<?php // Activity specific list items ?>
			<?php if( 'activity' == $component ) : ?>

				<?php if( bp_is_active( 'friends' ) && $my_friends_count ) : ?>
					<li id="activity-friends" class="dynamic" data-bp-scope="friends" data-bp-object="<?php echo $component; ?>">
						<a href="<?php echo $my_account_friends_link ?>" title="<?php esc_attr_e( 'The activity of my friends only.', 'bp-nouveau' ); ?>">
							<?php esc_html_e( 'My Friends', 'bp-nouveau' ); ?>
							<?php /* Following empty span will contain the number of newest activities corresponding to this scope */ ?>
							<span></span>
						</a>
					</li>
				<?php endif; ?>

				<?php if( bp_is_active( 'groups' ) && $my_groups_count ) :
				/**
				 * Fires before the listing of groups activity type tab.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_activity_type_tab_groups' ); ?>

					<li id="activity-groups" class="dynamic" data-bp-scope="groups" data-bp-object="activity">
						<a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_groups_slug() . '/'; ?>" title="<?php esc_attr_e( 'The activity of groups I am a member of.', 'bp-nouveau' ); ?>">
							<?php esc_html_e( 'My Groups', 'bp-nouveau' ); ?>
							<?php /* Following empty span will contain the number of newest activities corresponding to this scope */ ?>
							<span></span>
						</a>
					</li>
				<?php endif; ?>

				<?php if ( bp_activity_do_mentions() ) :
				/**
				 * Fires before the listing of mentions activity type tab.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_before_activity_type_tab_mentions' ); ?>

				<li id="activity-mentions" class="dynamic" data-bp-scope="mentions" data-bp-object="activity">
					<a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/mentions/'; ?>" title="<?php esc_attr_e( 'Activity that I have been mentioned in.', 'bp-nouveau' ); ?>">
						<?php _e( 'Mentions', 'bp-nouveau' ); ?>
						<?php /* Following empty span will contain the number of newest activities corresponding to this scope */ ?>
						<span><?php if ( bp_get_total_mention_count_for_user( bp_loggedin_user_id() ) ) bp_total_mention_count_for_user( bp_loggedin_user_id() ) ; ?></span>
					</a>
				</li>
				<?php endif; ?>

				<?php // end Activity specific list items ?>

			<?php elseif( is_user_logged_in() && $personal_items ) : ?>

				<li id="<?php echo $component; ?>-personal" data-bp-scope="personal" data-bp-object="<?php $component ;?>">
					<a href="<?php echo $user_account_comp_link; ?>">
						<?php printf( __( 'My %1$s %2$s', 'bp-nouveau' ), $component_name, $my_comp_count ); ?>
					</a>
				</li>

			<?php endif; ?>

		<?php endif; ?>

		<?php

			switch( $component ) {
				case 'groups' :
				/**
		 		* Fires inside the groups directory group filter input.
		 		*
		 		* @since 1.5.0
		 		*/
					do_action( 'bp_groups_directory_group_filter' );
				break;

				case 'members' :
			/**
		 	* Fires inside the members directory member types.
		 	*
		 	* @since 1.2.0
		 	*/

					do_action( 'bp_members_directory_member_types' );
				break;

				case 'activity' :
			/**
			 * Fires after the listing of activity type tabs.
			 *
			 * @since 1.2.0
			 */
					do_action( 'bp_activity_type_tabs' );
				break;
			} ?>

</menu><!-- .component-nav-wrapper -->
