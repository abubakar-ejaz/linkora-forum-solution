<?php

/**
 * Topics Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

do_action( 'bbp_template_before_topics_loop' ); ?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" class="bbp-topics">

	<li class="bbp-header">
		<ul class="forum-titles">
			<li class="bbp-topic-title"><?php echo esc_html__( 'TOPIC', 'disputo' ); ?></li>        
			<li class="bbp-topic-voice-count"><i class="fa fa-users" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'VOICES', 'disputo' ); ?>"></i></li>
			<li class="bbp-topic-reply-count"><i class="fa fa-comments" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'REPLIES', 'disputo' ); ?>"></i></li>
			<li class="bbp-topic-freshness"><i class="fa fa-clock-o" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'FRESHNESS', 'disputo' ); ?>"></i></li>
		</ul>
	</li>

	<li class="bbp-body">

		<?php while ( bbp_topics() ) : bbp_the_topic(); ?>

			<?php bbp_get_template_part( 'loop', 'single-topic' ); ?>

		<?php endwhile; ?>

	</li>

</ul>
<br>
<?php 
echo do_shortcode('[list_only_cities]');
do_action( 'bbp_template_after_topics_loop' ); ?>
