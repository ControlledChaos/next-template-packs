<?php
/**
 * BP Nouveau Default group's front template.
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */
?>

<div class="group-front-page">

	<?php if ( is_active_sidebar( 'sidebar-buddypress-groups' )  ) : ?>
		<div id="group-front-widgets" class="bp-sidebar bp-widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-buddypress-groups' ); ?>
		</div><!-- .bp-sidebar.bp-widget-area -->

	<?php elseif ( ! is_customize_preview() && bp_current_user_can( 'bp_moderate' ) ) : ?>

		<div class="bp-feedback info">
			<h4><?php esc_html_e( 'Manage the groups default front page', 'bp-nouveau' ) ;?></h4>
			<p>
				<?php printf(
					esc_html__( 'You can disable or enable %s or add %s to it.', 'bp-nouveau' ),
					bp_nouveau_groups_get_customizer_option_link(),
					bp_nouveau_groups_get_customizer_widgets_link()
				); ?>
			</p>
		</div>

	<?php endif; ?>

</div>
