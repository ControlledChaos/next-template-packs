<?php
/**
 * Friends Ajax functions
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Registers friends AJAX actions.
 */
bp_nouveau_register_ajax_actions( array(
	array( 'friends_remove_friend'       => array( 'function' => 'bp_nouveau_ajax_addremove_friend', 'nopriv' => false ) ),
	array( 'friends_add_friend'          => array( 'function' => 'bp_nouveau_ajax_addremove_friend', 'nopriv' => false ) ),
	array( 'friends_withdraw_friendship' => array( 'function' => 'bp_nouveau_ajax_addremove_friend', 'nopriv' => false ) ),
	array( 'friends_accept_friendship'   => array( 'function' => 'bp_nouveau_ajax_addremove_friend', 'nopriv' => false ) ),
	array( 'friends_reject_friendship'   => array( 'function' => 'bp_nouveau_ajax_addremove_friend', 'nopriv' => false ) ),
) );

/**
 * Friend/un-friend a user via a POST request.
 *
 * @since 1.0.0
 *
 * @return string HTML
 */
function bp_nouveau_ajax_addremove_friend() {
	$response = array(
		'feedback' => sprintf(
			'<div class="feedback error bp-ajax-message"><p>%s</p></div>',
			esc_html__( 'There was a problem performing this action. Please try again.', 'bp-nouveau' )
		)
	);

	// Bail if not a POST action.
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
		wp_send_json_error( $response );
	}

	if ( empty( $_POST['nonce'] ) || empty( $_POST['item_id'] ) || ! bp_is_active( 'friends' ) ) {
		wp_send_json_error( $response );
	}

	// Use default nonce
	$nonce = $_POST['nonce'];
	$check = 'bp_nouveau_friends';

	// Use a specific one for actions needed it
	if ( ! empty( $_POST['_wpnonce'] ) && ! empty( $_POST['action'] ) ) {
		$nonce = $_POST['_wpnonce'];
		$check = $_POST['action'];
	}

	// Nonce check!
	if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, $check ) ) {
		wp_send_json_error( $response );
	}

	// Cast fid as an integer.
	$friend_id = (int) $_POST['item_id'];

	// In the 2 first cases the $friend_id is a friendship id.
	if ( ! empty( $_POST['action'] ) && 'friends_accept_friendship' === $_POST['action'] ) {
		if ( ! friends_accept_friendship( $friend_id ) ) {
			wp_send_json_error( array( 'feedback' => sprintf(
				'<div class="bp-feedback error">%s</div>',
				esc_html__( 'There was a problem accepting that request. Please try again.', 'bp-nouveau' )
			) ) );
		} else {
			wp_send_json_success( array(
				'feedback' => sprintf(
					'<div class="bp-feedback success">%s</div>',
					esc_html__( 'Friendship accepted.', 'bp-nouveau' )
				),
				'type'     => 'success',
				'is_user'  => true,
			) );
		}

	// Rejecting a friendship
	} elseif ( ! empty( $_POST['action'] ) && 'friends_reject_friendship' === $_POST['action'] ) {
		if ( ! friends_reject_friendship( $friend_id ) ) {
			wp_send_json_error( array( 'feedback' => sprintf(
				'<div class="bp-feedback error">%s</div>',
				esc_html__( 'There was a problem rejecting that request. Please try again.', 'bp-nouveau' )
			) ) );
		} else {
			wp_send_json_success( array(
				'feedback' => sprintf(
					'<div class="bp-feedback success">%s</div>',
					esc_html__( 'Friendship rejected.', 'bp-nouveau' )
				),
				'type'     => 'success',
				'is_user'  => true,
			) );
		}

	// Trying to cancel friendship.
	} elseif ( 'is_friend' == BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
		if ( ! friends_remove_friend( bp_loggedin_user_id(), $friend_id ) ) {
			$response['feedback'] = sprintf(
				'<div class="bp-feedback error">%s</div>',
				esc_html__( 'Friendship could not be cancelled.', 'bp-nouveau' )
			);

			wp_send_json_error( $response );
		} else {
			$is_user = bp_is_my_profile();

			if ( ! $is_user ) {
				$response = array( 'contents' => bp_get_add_friend_button( $friend_id ) );
			} else {
				$response = array(
					'feedback' => sprintf(
						'<div class="bp-feedback success">%s</div>',
						esc_html__( 'Friendship cancelled.', 'bp-nouveau' )
					),
					'type'     => 'success',
					'is_user'  => $is_user,
				);
			}

			wp_send_json_success( $response );
		}

	// Trying to request friendship.
	} elseif ( 'not_friends' == BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
		if ( ! friends_add_friend( bp_loggedin_user_id(), $friend_id ) ) {
			$response['feedback'] = sprintf(
				'<div class="bp-feedback error">%s</div>',
				esc_html__( 'Friendship could not be requested.', 'bp-nouveau' )
			);

			wp_send_json_error( $response );
		} else {
			wp_send_json_success( array( 'contents' => bp_get_add_friend_button( $friend_id ) ) );
		}

	// Trying to cancel pending request.
	} elseif ( 'pending' == BP_Friends_Friendship::check_is_friend( bp_loggedin_user_id(), $friend_id ) ) {
		if ( friends_withdraw_friendship( bp_loggedin_user_id(), $friend_id ) ) {
			wp_send_json_success( array( 'contents' => bp_get_add_friend_button( $friend_id ) ) );
		} else {
			$response['feedback'] = sprintf(
				'<div class="bp-feedback error">%s</div>',
				esc_html__( 'Friendship request could not be cancelled.', 'bp-nouveau' )
			);

			wp_send_json_error( $response );
		}

	// Request already pending.
	} else {
		$response['feedback'] = sprintf(
			'<div class="bp-feedback error">%s</div>',
			esc_html__( 'Request Pending', 'bp-nouveau' )
		);

		wp_send_json_error( $response );
	}
}
