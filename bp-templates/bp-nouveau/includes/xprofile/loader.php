<?php
/**
 * BP Nouveau xProfile
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'BP_Nouveau_xProfile' ) ) :
/**
 * xProfile Loader class
 *
 * @since 1.0.0
 */
class BP_Nouveau_xProfile {
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
		require( trailingslashit( $this->dir ) . 'functions.php'     );
		require( trailingslashit( $this->dir ) . 'template-tags.php' );
	}

	/**
	 * Register do_action() hooks
	 *
	 * @since 1.0.0
	 */
	private function setup_actions() {
		// Enqueue the scripts
		add_action( 'bp_nouveau_enqueue_scripts', 'bp_nouveau_xprofile_enqueue_scripts' );
	}

	/**
	 * Register add_filter() hooks
	 *
	 * @since 1.0.0
	 */
	private function setup_filters() {
		// Register xprofile scripts
		add_filter( 'bp_nouveau_register_scripts', 'bp_nouveau_xprofile_register_scripts', 10, 1 );
	}
}

endif;

/**
 * Launch the xProfile loader class.
 *
 * @since 1.0.0
 */
function bp_nouveau_xprofile( $bp_nouveau = null ) {
	if ( is_null( $bp_nouveau ) ) {
		return;
	}

	$bp_nouveau->xprofile = new BP_Nouveau_xProfile();
}
add_action( 'bp_nouveau_includes', 'bp_nouveau_xprofile', 10, 1 );
