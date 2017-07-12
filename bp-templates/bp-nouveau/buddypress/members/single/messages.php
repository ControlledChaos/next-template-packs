<?php
/**
 * BuddyPress - Users Messages
 *
 * @package BuddyPress
 * @subpackage bp-nouveau
 */

?>

<nav class="<?php bp_nouveau_single_item_subnav_classes(); ?>" id="subnav" role="navigation" aria-label="<?php esc_attr_e( 'Messages menu', 'buddypress' ); ?>">
	<ul class="subnav">

		<?php bp_get_template_part( 'members/single/parts/item-subnav' ); ?>

	</ul>
</nav><!-- .bp-navs -->

<?php if ( ! in_array( bp_current_action(), array( 'inbox', 'sentbox', 'starred', 'view', 'compose', 'notices' ), true ) ) :

	bp_get_template_part( 'members/single/plugins' );

else :

	bp_nouveau_messages_member_interface();

endif ;?>

