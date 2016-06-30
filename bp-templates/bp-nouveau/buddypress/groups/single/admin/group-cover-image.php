<?php
/**
 * BP Nouveau Group's cover image template.
 *
 * @since 1.0.0
 *
 * @package BP Nouveau
 */
?>

<h4><?php _e( 'Change Cover Image', 'bp-nouveau' ); ?></h4>

<p><?php _e( 'The Cover Image will be used to customize the header of your group.', 'bp-nouveau' ); ?></p>

<?php bp_attachments_get_template_part( 'cover-images/index' );
