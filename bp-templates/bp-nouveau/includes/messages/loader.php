<?php
/**
 * BP Nouveau Messages
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BP_Nouveau_Messages' ) ) :
/**
 * Messages Loader class
 *
 * @since 1.0.0
 */
class BP_Nouveau_Messages {
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->setup_globals();
		$this->includes();

		// Setup list of add_action() hooks
		$this->setup_actions();

		// Setup list of add_filter() hooks
		$this->setup_filters();
	}

	/**
	 * Globals
	 *
	 * @since 1.0.0
	 */
	private function setup_globals() {
		$this->dir = dirname( __FILE__ );
	}

	/**
	 * Include needed files
	 *
	 * @since 1.0.0
	 */
	private function includes() {
		require( trailingslashit( $this->dir ) . 'classes.php'       );
		require( trailingslashit( $this->dir ) . 'functions.php'     );
		require( trailingslashit( $this->dir ) . 'template-tags.php' );
		require( trailingslashit( $this->dir ) . 'ajax.php'          );
	}

	/**
	 * Register do_action() hooks
	 *
	 * @since 1.0.0
	 */
	private function setup_actions() {
		// Notices
		add_action( 'widgets_init',     'bp_nouveau_unregister_notices_widget'       );
		add_action( 'template_notices', 'bp_nouveau_sitewide_notices',          9999 );

		// Messages
		add_action( 'bp_messages_setup_nav', 'bp_nouveau_messages_adjust_nav' );

		// Remove deprecated scripts
		remove_action( 'bp_enqueue_scripts', 'messages_add_autocomplete_js' );

		// Enqueue the scripts for the new UI
		add_action( 'bp_nouveau_enqueue_scripts', 'bp_nouveau_messages_enqueue_scripts' );

		$ajax_actions = array(
			array( 'messages_send_message'             => array( 'function' => 'bp_nouveau_ajax_messages_send_message',      'nopriv' => false ) ),
			array( 'messages_send_reply'               => array( 'function' => 'bp_nouveau_ajax_messages_send_reply',        'nopriv' => false ) ),
			array( 'messages_get_user_message_threads' => array( 'function' => 'bp_nouveau_ajax_get_user_message_threads',   'nopriv' => false ) ),
			array( 'messages_thread_read'              => array( 'function' => 'bp_nouveau_ajax_messages_thread_read',       'nopriv' => false ) ),
			array( 'messages_get_thread_messages'      => array( 'function' => 'bp_nouveau_ajax_get_thread_messages',        'nopriv' => false ) ),
			array( 'messages_delete'                   => array( 'function' => 'bp_nouveau_ajax_delete_thread_messages',     'nopriv' => false ) ),
			array( 'messages_unstar'                   => array( 'function' => 'bp_nouveau_ajax_star_thread_messages',       'nopriv' => false ) ),
			array( 'messages_star'                     => array( 'function' => 'bp_nouveau_ajax_star_thread_messages',       'nopriv' => false ) ),
			array( 'messages_unread'                   => array( 'function' => 'bp_nouveau_ajax_readunread_thread_messages', 'nopriv' => false ) ),
			array( 'messages_read'                     => array( 'function' => 'bp_nouveau_ajax_readunread_thread_messages', 'nopriv' => false ) ),
		);

		foreach ( $ajax_actions as $ajax_action ) {
			$action = key( $ajax_action );

			add_action( 'wp_ajax_' . $action, $ajax_action[ $action ]['function'] );

			if ( ! empty( $ajax_action[ $action ]['nopriv'] ) ) {
				add_action( 'wp_ajax_nopriv_' . $action, $ajax_action[ $action ]['function'] );
			}
		}
	}

	/**
	 * Register add_filter() hooks
	 *
	 * @since 1.0.0
	 */
	private function setup_filters() {
		// Enqueue specific styles
		add_filter( 'bp_nouveau_enqueue_styles', 'bp_nouveau_messages_enqueue_styles', 10, 1 );

		// Register messages scripts
		add_filter( 'bp_nouveau_register_scripts', 'bp_nouveau_messages_register_scripts', 10, 1 );

		// Localize Scripts
		add_filter( 'bp_core_get_js_strings', 'bp_nouveau_messages_localize_scripts', 10, 1 );

		// Notices
		add_filter( 'bp_messages_single_new_message_notification', 'bp_nouveau_format_notice_notification_for_user',  10, 1 );
		add_filter( 'bp_notifications_get_all_notifications_for_user', 'bp_nouveau_add_notice_notification_for_user', 10, 2 );

		// Messages
		add_filter( 'bp_messages_admin_nav', 'bp_nouveau_messages_adjust_admin_nav', 10, 1 );

		remove_filter( 'messages_notice_message_before_save',  'wp_filter_kses', 1 );
		remove_filter( 'messages_message_content_before_save', 'wp_filter_kses', 1 );
		remove_filter( 'bp_get_the_thread_message_content',    'wp_filter_kses', 1 );

		add_filter( 'messages_notice_message_before_save',  'wp_filter_post_kses', 1 );
		add_filter( 'messages_message_content_before_save', 'wp_filter_post_kses', 1 );
		add_filter( 'bp_get_the_thread_message_content',    'wp_filter_post_kses', 1 );
		add_filter( 'bp_get_message_thread_content',        'wp_filter_post_kses', 1 );
		add_filter( 'bp_get_message_thread_content',        'wptexturize'            );
		add_filter( 'bp_get_message_thread_content',        'stripslashes_deep',   1 );
		add_filter( 'bp_get_message_thread_content',        'convert_smilies',     2 );
		add_filter( 'bp_get_message_thread_content',        'convert_chars'          );
		add_filter( 'bp_get_message_thread_content',        'make_clickable',      9 );
		add_filter( 'bp_get_message_thread_content',        'wpautop'                );
	}
}

endif;

/**
 * Launch the Messages loader class.
 *
 * @since 1.0.0
 */
function bp_nouveau_messages( $bp_nouveau = null ) {
	if ( is_null( $bp_nouveau ) ) {
		return;
	}

	$bp_nouveau->messages = new BP_Nouveau_Messages();
}
add_action( 'bp_nouveau_includes', 'bp_nouveau_messages', 10, 1 );
