<?php
/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter().
 *
 * @package BuddyPress
 * @subpackage bp-nouveau
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="groups-list" class="<?php bp_nouveau_loop_classes(); ?>">

	<?php while ( bp_groups() ) : bp_the_group(); ?>

		<li <?php bp_group_class( array('item-entry') ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
			<div class="wrap">

			<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
				<div class="item-avatar">
					<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>
				</div>
			<?php endif; ?>

			<div class="item">

				<h2 class="list-title groups-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></h2>

				<div class="meta"><?php bp_nouveau_group_meta(); ?></div>

				<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'bp-nouveau' ), bp_get_group_last_active() ); ?></span></div>

				<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

				<?php bp_nouveau_groups_loop_item(); ?>

			</div>

			<?php bp_nouveau_groups_loop_buttons(); ?>

			<?php if ( bp_nouveau_group_has_meta() ) : ?>

			<?php endif; ?>
			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else:

	bp_nouveau_user_feedback( 'groups-loop-none' );

endif; ?>

<?php bp_nouveau_after_loop(); ?>
