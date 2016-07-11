<?php
/**
 * Activity Ajax functions
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Mark an activity as a favourite via a POST request.
 *
 * @since 1.0.0
 *
 * @return string HTML
 */
function bp_nouveau_ajax_mark_activity_favorite() {
	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error();
	}

	// Nonce check!
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'bp_nouveau_activity' ) ) {
		wp_send_json_error();
	}

	if ( bp_activity_add_user_favorite( $_POST['id'] ) ) {
		$response = array( 'content' => __( 'Remove Favorite', 'bp-nouveau' ) );

		if ( ! bp_is_user() ) {
			$fav_count = (int) bp_get_total_favorite_count_for_user( bp_loggedin_user_id() );

			if ( 1 === $fav_count ) {
				$response['directory_tab'] = '<li id="activity-favorites" data-bp-scope="favorites" data-bp-object="activity">
					<a href="' . bp_loggedin_user_domain() . bp_get_activity_slug() . '/favorites/" title="' . esc_attr__( "The activity I've marked as a favorite.", 'bp-nouveau' ) . '">
						' . esc_html__( 'My Favorites', 'bp-nouveau' ) . '
					</a>
				</li>';
			} else {
				$response['fav_count'] = $fav_count;
			}
		}

		wp_send_json_success( $response );
	} else {
		wp_send_json_error();
	}
}

/**
 * Un-favourite an activity via a POST request.
 *
 * @since 1.0.0
 *
 * @return string HTML
 */
function bp_nouveau_ajax_unmark_activity_favorite() {
	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error();
	}

	// Nonce check!
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'bp_nouveau_activity' ) ) {
		wp_send_json_error();
	}

	if ( bp_activity_remove_user_favorite( $_POST['id'] ) ) {
		$response = array( 'content' => __( 'Favorite', 'bp-nouveau' ) );

		$fav_count = (int) bp_get_total_favorite_count_for_user( bp_loggedin_user_id() );

		if ( 0 === $fav_count && ! bp_is_single_activity() ) {
			$response['no_favorite'] = '<li><div class="bp-feedback bp-messages info">
				' . __( 'Sorry, there was no activity found. Please try a different filter.', 'bp-nouveau' ) . '
			</div></li>';
		} else {
			$response['fav_count'] = $fav_count;
		}

		wp_send_json_success( $response );
	} else {
		wp_send_json_error();
	}
}

function bp_nouveau_ajax_clear_new_mentions() {
	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error();
	}

	// Nonce check!
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'bp_nouveau_activity' ) ) {
		wp_send_json_error();
	}

	bp_activity_clear_new_mentions( bp_loggedin_user_id() );
	wp_send_json_success();
}

/**
 * Deletes an Activity item received via a POST request.
 *
 * @since 1.0.0
 *
 * @return mixed String on error, void on success.
 */
function bp_nouveau_ajax_delete_activity() {
	$response = array(
		'feedback' => sprintf(
			'<div class="bp-feedback bp-messages error">%s</div>',
			esc_html__( 'There was a problem when deleting. Please try again.', 'bp-nouveau' )
		)
	);

	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error( $response );
	}

	// Nonce check!
	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'bp_activity_delete_link' ) ) {
		wp_send_json_error( $response );
	}

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( $response );
	}

	if ( empty( $_POST['id'] ) || ! is_numeric( $_POST['id'] ) ) {
		wp_send_json_error( $response );
	}

	$activity = new BP_Activity_Activity( (int) $_POST['id'] );

	// Check access.
	if ( ! bp_activity_user_can_delete( $activity ) ) {
		wp_send_json_error( $response );
	}

	/** This action is documented in bp-activity/bp-activity-actions.php */
	do_action( 'bp_activity_before_action_delete_activity', $activity->id, $activity->user_id );

	if ( ! bp_activity_delete( array( 'id' => $activity->id, 'user_id' => $activity->user_id ) ) ) {
		wp_send_json_error( $response );
	}

	/** This action is documented in bp-activity/bp-activity-actions.php */
	do_action( 'bp_activity_action_delete_activity', $activity->id, $activity->user_id );

	// The activity has been deleted successfully
	$response = array( 'deleted' => $activity->id );

	// If on a single activity redirect to user's home.
	if ( ! empty( $_POST['is_single'] ) ) {
		$response['redirect'] = bp_core_get_user_domain( $activity->user_id );
		bp_core_add_message( __( 'Activity deleted successfully', 'bp-nouveau' ) );
	}

	wp_send_json_success( $response );
}

/**
 * Deletes an Activity comment received via a POST request.
 *
 * @todo implement the delete_activity_comment ajax action
 * in buddypress-activity.js
 *
 * @since 1.0.0
 *
 * @return mixed String on error, void on success.
 */
function bp_nouveau_ajax_delete_activity_comment() {
	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return;

	// Check the nonce.
	check_admin_referer( 'bp_activity_delete_link' );

	if ( ! is_user_logged_in() )
		exit( '-1' );

	$comment = new BP_Activity_Activity( $_POST['id'] );

	// Check access.
	if ( ! bp_current_user_can( 'bp_moderate' ) && $comment->user_id != bp_loggedin_user_id() )
		exit( '-1' );

	if ( empty( $_POST['id'] ) || ! is_numeric( $_POST['id'] ) )
		exit( '-1' );

	/** This action is documented in bp-activity/bp-activity-actions.php */
	do_action( 'bp_activity_before_action_delete_activity', $_POST['id'], $comment->user_id );

	if ( ! bp_activity_delete_comment( $comment->item_id, $comment->id ) )
		exit( '-1<div id="message" class="error bp-ajax-message"><p>' . __( 'There was a problem when deleting. Please try again.', 'bp-nouveau' ) . '</p></div>' );

	/** This action is documented in bp-activity/bp-activity-actions.php */
	do_action( 'bp_activity_action_delete_activity', $_POST['id'], $comment->user_id );
	exit;
}

/**
 * Fetches an activity's full, non-excerpted content via a POST request.
 * Used for the 'Read More' link on long activity items.
 *
 * @since 1.0.0
 *
 * @return string HTML
 */
function bp_nouveau_ajax_get_single_activity_content() {
	$response = array(
		'feedback' => sprintf(
			'<div class="feedback error bp-ajax-message"><p>%s</p></div>',
			esc_html__( 'There was a problem displaying the content. Please try again.', 'bp-nouveau' )
		)
	);

	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error( $response );
	}

	// Nonce check!
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'bp_nouveau_activity' ) ) {
		wp_send_json_error( $response );
	}

	$activity_array = bp_activity_get_specific( array(
		'activity_ids'     => $_POST['id'],
		'display_comments' => 'stream'
	) );

	if ( empty( $activity_array['activities'][0] ) ) {
		wp_send_json_error( $response );
	}

	$activity = $activity_array['activities'][0];

	/**
	 * Fires before the return of an activity's full, non-excerpted content via a POST request.
	 *
	 * @since 1.0.0
	 *
	 * @param string $activity Activity content. Passed by reference.
	 */
	do_action_ref_array( 'bp_nouveau_get_single_activity_content', array( &$activity ) );

	// Activity content retrieved through AJAX should run through normal filters, but not be truncated.
	remove_filter( 'bp_get_activity_content_body', 'bp_activity_truncate_entry', 5 );

	/** This filter is documented in bp-activity/bp-activity-template.php */
	$content = apply_filters( 'bp_get_activity_content_body', $activity->content );

	wp_send_json_success( array( 'contents' => $content ) );
}

/**
 * Posts new Activity comments received via a POST request.
 *
 * @since 1.0.0
 *
 * @global BP_Activity_Template $activities_template
 *
 * @return string HTML
 */
function bp_nouveau_ajax_new_activity_comment() {
	global $activities_template;
	$bp = buddypress();

	$response = array(
		'feedback' => sprintf(
			'<div class="feedback error bp-ajax-message"><p>%s</p></div>',
			esc_html__( 'There was an error posting your reply. Please try again.', 'bp-nouveau' )
		)
	);

	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error( $response );
	}

	// Nonce check!
	if ( empty( $_POST['_wpnonce_new_activity_comment'] ) || ! wp_verify_nonce( $_POST['_wpnonce_new_activity_comment'], 'new_activity_comment' ) ) {
		wp_send_json_error( $response );
	}

	if ( ! is_user_logged_in() ) {
		wp_send_json_error( $response );
	}

	if ( empty( $_POST['content'] ) ) {
		wp_send_json_error( array( 'feedback' => sprintf(
			'<div class="feedback error bp-ajax-message"><p>%s</p></div>',
			esc_html__( 'Please do not leave the comment area blank.', 'bp-nouveau' )
		) ) );
	}

	if ( empty( $_POST['form_id'] ) || empty( $_POST['comment_id'] ) || ! is_numeric( $_POST['form_id'] ) || ! is_numeric( $_POST['comment_id'] ) ) {
		wp_send_json_error( $response );
	}

	$comment_id = bp_activity_new_comment( array(
		'activity_id' => $_POST['form_id'],
		'content'     => $_POST['content'],
		'parent_id'   => $_POST['comment_id'],
	) );

	if ( ! $comment_id ) {
		if ( ! empty( $bp->activity->errors['new_comment'] ) && is_wp_error( $bp->activity->errors['new_comment'] ) ) {
			$response = array( 'feedback' => sprintf(
				'<div class="feedback error bp-ajax-message"><p>%s</p></div>',
				esc_html( $bp->activity->errors['new_comment']->get_error_message() )
			) );
			unset( $bp->activity->errors['new_comment'] );
		}

		wp_send_json_error( $response );
	}

	// Load the new activity item into the $activities_template global.
	bp_has_activities( array(
		'display_comments' => 'stream',
		'hide_spam'        => false,
		'show_hidden'      => true,
		'include'          => $comment_id,
	) );

	// Swap the current comment with the activity item we just loaded.
	if ( isset( $activities_template->activities[0] ) ) {
		$activities_template->activity = new stdClass();
		$activities_template->activity->id = $activities_template->activities[0]->item_id;
		$activities_template->activity->current_comment = $activities_template->activities[0];

		// Because the whole tree has not been loaded, we manually
		// determine depth.
		$depth = 1;
		$parent_id = (int) $activities_template->activities[0]->secondary_item_id;
		while ( $parent_id !== (int) $activities_template->activities[0]->item_id ) {
			$depth++;
			$p_obj = new BP_Activity_Activity( $parent_id );
			$parent_id = (int) $p_obj->secondary_item_id;
		}
		$activities_template->activity->current_comment->depth = $depth;
	}

	ob_start();
	// Get activity comment template part.
	bp_get_template_part( 'activity/comment' );
	$response = array( 'contents' => ob_get_contents() );
	ob_end_clean();

	unset( $activities_template );

	wp_send_json_success( $response );
}

/**
 * Get items to attach the activity to.
 * This is used within the activity post form autocomplete field.
 *
 * @since 1.0.0
 *
 * @return string JSON reply
 */
function bp_nouveau_ajax_get_activity_objects() {
	$response = array();

	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'bp_nouveau_activity' ) ) {
		wp_send_json_error( $response );
	}

	if ( 'group' === $_POST['type'] ) {
		$groups = groups_get_groups( array(
			'user_id'           => bp_loggedin_user_id(),
			'search_terms'      => $_POST['search'],
			'show_hidden'       => true,
			'per_page'          => 2,
		) );

		wp_send_json_success( array_map( 'bp_nouveau_prepare_group_for_js', $groups['groups'] ) );
	} else {
		$response = apply_filters( 'bp_nouveau_get_activity_custom_objects', $response, $_POST['type'] );
	}

	if ( empty( $response ) ) {
		wp_send_json_error( array( 'error' => __( 'No items were found.', 'bp-nouveau' ) ) );
	} else {
		wp_send_json_success( $response );
	}
}

/**
 * Processes Activity updates received via a POST request.
 *
 * @since 1.0.0
 *
 * @return string JSON reply
 */
function bp_nouveau_ajax_post_update() {
	$bp = buddypress();

	if ( ! is_user_logged_in() || empty( $_POST['_wpnonce_post_update'] ) || ! wp_verify_nonce( $_POST['_wpnonce_post_update'], 'post_update' ) ) {
		wp_send_json_error();
	}

	if ( empty( $_POST['content'] ) ) {
		wp_send_json_error( array(
			'message' => __( 'Please enter some content to post.', 'bp-nouveau' ),
		) );
	}

	$activity_id = 0;
	$item_id     = 0;
	$object      = '';
	$is_private  = false;


	// Try to get the item id from posted variables.
	if ( ! empty( $_POST['item_id'] ) ) {
		$item_id = (int) $_POST['item_id'];
	}

	// Try to get the object from posted variables.
	if ( ! empty( $_POST['object'] ) ) {
		$object  = sanitize_key( $_POST['object'] );

	// If the object is not set and we're in a group, set the item id and the object
	} elseif ( bp_is_group() ) {
		$item_id = bp_get_current_group_id();
		$object = 'group';
		$status = groups_get_current_group()->status;
	}

	if ( 'user' === $object && bp_is_active( 'activity' ) ) {
		$activity_id = bp_activity_post_update( array( 'content' => $_POST['content'] ) );

	} elseif ( 'group' === $object ) {
		if ( $item_id && bp_is_active( 'groups' ) ) {
			// This function is setting the current group!
			$activity_id = groups_post_update( array( 'content' => $_POST['content'], 'group_id' => $item_id ) );

			if ( empty( $status ) ) {
				if ( ! empty( $bp->groups->current_group->status ) ) {
					$status = $bp->groups->current_group->status;
				} else {
					$group  = groups_get_group( array( 'group_id' => $group_id ) );
					$status = $group->status;
				}

				$is_private = 'public' !== $status;
			}
		}

	} else {

		/** This filter is documented in bp-activity/bp-activity-actions.php */
		$activity_id = apply_filters( 'bp_activity_custom_update', false, $object, $item_id, $_POST['content'] );
	}

	if ( empty( $activity_id ) ) {
		wp_send_json_error( array(
			'message' => __( 'There was a problem posting your update. Please try again.', 'bp-nouveau' ),
		) );
	}

	ob_start();
	if ( bp_has_activities( array( 'include' => $activity_id, 'show_hidden' => $is_private ) ) ) {
		while ( bp_activities() ) {
			bp_the_activity();
			bp_get_template_part( 'activity/entry' );
		}
	}
	$acivity = ob_get_contents();
	ob_end_clean();

	wp_send_json_success( array(
		'id'           => $activity_id,
		'message'      => sprintf( __( 'Update posted <a href="%s" class="just-posted">View activity</a>', 'bp-nouveau' ), esc_url( bp_activity_get_permalink( $activity_id ) ) ),
		'activity'     => $acivity,
		'is_private'   => apply_filters( 'bp_nouveau_ajax_post_update_is_private', $is_private ),
		'is_directory' => bp_is_activity_directory(),
	) );
}

/**
 * AJAX spam an activity item or comment.
 *
 * @todo implement the delete_activity_comment ajax action
 * in buddypress-activity.js
 *
 * @since 1.0.0
 *
 * @return mixed String on error, void on success.
 */
function bp_nouveau_ajax_spam_activity() {
	$bp = buddypress();

	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return;

	// Check that user is logged in, Activity Streams are enabled, and Akismet is present.
	if ( ! is_user_logged_in() || ! bp_is_active( 'activity' ) || empty( $bp->activity->akismet ) )
		exit( '-1' );

	// Check an item ID was passed.
	if ( empty( $_POST['id'] ) || ! is_numeric( $_POST['id'] ) )
		exit( '-1' );

	// Is the current user allowed to spam items?
	if ( ! bp_activity_user_can_mark_spam() )
		exit( '-1' );

	// Load up the activity item.
	$activity = new BP_Activity_Activity( (int) $_POST['id'] );
	if ( empty( $activity->component ) )
		exit( '-1' );

	// Check nonce.
	check_admin_referer( 'bp_activity_akismet_spam_' . $activity->id );

	/** This action is documented in bp-activity/bp-activity-actions.php */
	do_action( 'bp_activity_before_action_spam_activity', $activity->id, $activity );

	// Mark as spam.
	bp_activity_mark_as_spam( $activity );
	$activity->save();

	/** This action is documented in bp-activity/bp-activity-actions.php */
	do_action( 'bp_activity_action_spam_activity', $activity->id, $activity->user_id );
	exit;
}
