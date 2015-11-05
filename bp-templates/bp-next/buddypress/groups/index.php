<?php
/**
 * BuddyPress - Groups
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires at the top of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_before_directory_groups_page' ); ?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the groups.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups' ); ?>

	<?php

	/**
	 * Fires before the display of the groups content.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_groups_content' ); ?>

	<?php

	/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
	do_action( 'template_notices' ); ?>

	<?php if ( ! bp_next_is_object_nav_in_sidebar() ) : ?>

		<?php bp_get_template_part( 'groups/object-nav' ); ?>

	<?php endif; ?>

	<div class="item-list-tabs" id="subnav" role="navigation">
		<ul>
			<li class="dir-search" role="search" data-bp-search="groups">
				<?php bp_directory_groups_search_form(); ?>
			</li>
			<?php

			/**
			 * Fires inside the groups directory group types.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_groups_directory_group_types' ); ?>

			<li id="groups-order-select" class="last filter">

				<label for="groups-order-by"><span class="bp-screen-reader-text"><?php _e( 'Order By:', 'bp-next' ); ?></span></label>

				<select id="groups-order-by" data-bp-filter="groups">
					<option value="active"><?php _e( 'Last Active', 'bp-next' ); ?></option>
					<option value="popular"><?php _e( 'Most Members', 'bp-next' ); ?></option>
					<option value="newest"><?php _e( 'Newly Created', 'bp-next' ); ?></option>
					<option value="alphabetical"><?php _e( 'Alphabetical', 'bp-next' ); ?></option>

					<?php

					/**
					 * Fires inside the groups directory group order options.
					 *
					 * @since 1.2.0
					 */
					do_action( 'bp_groups_directory_order_options' ); ?>
				</select>
			</li>
		</ul>
	</div>

	<div id="groups-dir-list" class="groups dir-list" data-bp-list="groups">
		<div id="bp-ajax-loader">loading</div>
	</div><!-- #groups-dir-list -->

	<?php

	/**
		 * Fires and displays the group content.
		 *
		 * @since 1.1.0
		 */
	do_action( 'bp_directory_groups_content' ); ?>

	<?php wp_nonce_field( 'directory_groups', '_wpnonce-groups-filter' ); ?>

	<?php

	/**
		 * Fires after the display of the groups content.
		 *
		 * @since 1.1.0
		 */
	do_action( 'bp_after_directory_groups_content' ); ?>

	<?php

	/**
 	 * Fires after the display of the groups.
 	 *
 	 * @since 1.1.0
 	 */
	do_action( 'bp_after_directory_groups' ); ?>

</div><!-- #buddypress -->

<?php

/**
 * Fires at the bottom of the groups directory template file.
 *
 * @since 1.5.0
 */
do_action( 'bp_after_directory_groups_page' );
