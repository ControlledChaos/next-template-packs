<?php
/**
 * BuddyPress - Users Blogs
 *
 * @since  1.0.0
 *
 * @package BP Nouveau
 */

?>

<div class="item-list-tabs" id="subnav" role="navigation">
	<ul>

		<?php bp_get_options_nav(); ?>

		<li id="blogs-order-select" class="last filter">

			<label for="blogs-order-by"><span class="bp-screen-reader-text"><?php _e( 'Order By:', 'bp-nouveau' ); ?></span></label>
			<select id="blogs-order-by" data-bp-filter="blogs">

				<?php bp_nouveau_filter_options() ;?>

			</select>
		</li>
	</ul>
</div><!-- .item-list-tabs -->

<?php
switch ( bp_current_action() ) :

	// Home/My Blogs
	case 'my-sites' :

		bp_nouveau_member_hook( 'before', 'blogs_content' ); ?>

		<div class="blogs myblogs" data-bp-list="blogs">

			<div id="bp-ajax-loader"><?php esc_html_e( 'Loading the blogs you are a contributor of, please wait.', 'bp-nouveau' ) ;?></div>

		</div><!-- .blogs.myblogs -->

		<?php bp_nouveau_member_hook( 'after', 'blogs_content' );
		break;

	// Any other
	default :
		bp_get_template_part( 'members/single/plugins' );
		break;
endswitch;
