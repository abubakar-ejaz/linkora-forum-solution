<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">

	<li class="bbp-header">

		<ul class="forum-titles">
			<li class="bbp-forum-info"><?php esc_html_e( 'Forum', 'disputo' ); ?></li>
			<li class="bbp-forum-topic-count"><i class="fa fa-comment" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'TOPICS', 'disputo' ); ?>"></i></li>
			<li class="bbp-forum-reply-count"><i class="fa fa-comments" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'REPLIES', 'disputo' ); ?>"></i></li>
			<li class="bbp-forum-freshness"><i class="fa fa-clock-o" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'FRESHNESS', 'disputo' ); ?>"></i></li>
		</ul>

	</li>

	<li class="bbp-body">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</li>

</ul>
<br>
<?php 

do_action( 'bbp_template_after_forums_loop' ); 
echo do_shortcode('[list_only_cities]'); ?>