<?php
/**
 * BuddyPress - Groups Members
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */
?>


	<div class="subnav-filters filters clearfix">

			<?php bp_nouveau_search_form(); ?>

		<?php bp_get_template_part( 'common/filters/groups-screens-filters' ); ?>

	</div>


<div id="members-group-list" class="group_members dir-list" data-bp-list="group_members">

	<div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'group-members-loading' ); ?></div>

</div><!-- .group_members.dir-list -->
