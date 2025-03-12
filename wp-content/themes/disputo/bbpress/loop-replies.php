<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>

<ul class="disputo-replies-bar">
    <li class="disputo-replies-title">
        <?php if ( !bbp_show_lead_topic() ) : ?>
        <?php esc_html_e( 'Posts', 'disputo' ); ?>
        <?php else : ?>
        <?php esc_html_e( 'Replies', 'disputo' ); ?>
        <?php endif; ?>
    </li>
    <li class="disputo-replies-links">
        <span class="disputo-replies-subscription"><?php bbp_topic_subscription_link(array('before' => '','after' => '')); ?></span>
        <span class="disputo-replies-favorites"><?php bbp_topic_favorite_link(); ?></span>
    </li>
</ul>

<ul id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">
    <li>
        <?php if ( bbp_thread_replies() ) : ?>

			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>
    </li>
</ul>

<?php do_action( 'bbp_template_after_replies_loop' ); ?>