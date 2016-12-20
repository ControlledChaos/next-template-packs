<?php
/**
 * xProfile Template tags
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Fire specific hooks into the single members xprofile templates
 *
 * @since 1.0.0
 *
 * @param string $when    'before' or 'after'
 * @param string $suffix  Use it to add terms at the end of the hook name
 */
function bp_nouveau_xprofile_hook( $when = '', $suffix = '' ) {
	$hook = array( 'bp' );

	if ( ! empty( $when ) ) {
		$hook[] = $when;
	}

	// It's a xprofile hook
	$hook[] = 'profile';

	if ( ! empty( $suffix ) ) {
		$hook[] = $suffix;
	}

	/**
	 * @since 1.1.0 (BuddyPress) for the 'avatar_upload_content', 'edit_content', 'field_content',
	 *                           'field_item', 'field_buttons', 'profile_content' suffixes.
	 * @since 1.2.0 (BuddyPress) for the 'loop_content' suffix.
	 * @since 2.4.0 (BuddyPress) for the 'edit_cover_image' suffix.
	 */
	return bp_nouveau_hook( $hook );
}

/**
 * Template tag to output the field visibility markup in
 * edit and signup screens.
 *
 * @since  1.0.0
 *
 * @return string HTML Output
 */
function bp_nouveau_xprofile_edit_visibilty() {
	/**
	 * Fires before the display of visibility options for the field.
	 *
	 * @since 1.7.0
	 */
	do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

	bp_get_template_part( 'members/single/parts/profile-visibility' );

	/**
	 * Fires after the visibility options for a field.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_custom_profile_edit_fields' );
}


/*

// in progress - change the xprofile group name 'base' to something better or user set
// primary function xprofile/bp-xprofile-template.php L: 273
function nouveau_the_profile_group_name( $base_name = null ) {
	echo nouveau_get_the_profile_group_name( $base_name );
}

function nouveau_get_the_profile_group_name( $base_name ) {
	global $group;

	if( empty( $base_name ) )
		$base_name = 'Primary Account';

	if('Base' == $group->name ) {
		$group->name = $base_name;
	}

	$base_name = apply_filters('nouveau_get_the_profile_group_name', $group->name );

	return $base_name;
}
add_filter('bp_get_the_profile_group_name', 'nouveau_get_the_profile_group_name');
*/
