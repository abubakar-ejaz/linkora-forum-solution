<?php

/**
 * User Roles Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="form-group">
	<label for="role"><?php esc_html_e( 'Blog Role', 'disputo' ) ?></label>
	<?php bbp_edit_user_blog_role(); ?>
</div>

<div class="form-group">
	<label for="forum-role"><?php esc_html_e( 'Forum Role', 'disputo' ) ?></label>
	<?php bbp_edit_user_forums_role(); ?>
</div>
