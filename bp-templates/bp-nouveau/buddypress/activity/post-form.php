<?php
/**
 * BuddyPress - Activity Post Form
 *
 * @package BuddyPress
 * @subpackage bp-nouveau
 */

?>

<?php
/**
 * Template tag to prepare the activity post form
 * checks capability and enqueue needed scripts.
 */
bp_nouveau_before_activity_post_form() ;?>

<div id="bp-nouveau-activity-form"></div>

<?php
/**
 * Template tag to load the Javascript
 * templates of the Post form UI
 */
bp_nouveau_after_activity_post_form() ;?>
