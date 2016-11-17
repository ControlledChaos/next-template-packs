<?php
/**
 * BuddyPress - Users Groups
 *
 * @since  1.0.0
 *
 * @package BP Nouveau
 */

?>

<div class="bp-navs bp-subnavs user-subnav no-ajax" id="subnav" role="navigation">
	<ul class="subnav">

		<?php if ( bp_is_my_profile() ) : ?>

			<?php bp_get_template_part( 'members/single/parts/item-subnav' ); ?>

		<?php endif ; ?>

	</ul>
</div><!-- .bp-navs -->

<?php if ( ! bp_is_current_action( 'invites' ) ) : ?>


		<div class="subnav-filters filters">
			<ul>
			<?php bp_nouveau_search_form(); ?>
			</ul>

			<?php bp_get_template_part('common/filters/user-screens-filters'); ?>

		</div><!-- .subnav-filters -->

<?php endif; ?>

<?php

switch ( bp_current_action() ) :

	// Home/My Groups
	case 'my-groups' :

		bp_nouveau_member_hook( 'before', 'groups_content' ); ?>

		<div class="groups mygroups" data-bp-list="groups">

			<div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'member-groups-loading' ) ;?></div>

		</div>

		<?php bp_nouveau_member_hook( 'after', 'groups_content' );
		break;

	// Group Invitations
	case 'invites' :
		bp_get_template_part( 'members/single/groups/invites' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
