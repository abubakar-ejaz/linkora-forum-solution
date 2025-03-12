<?php

/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="disputo-forum-search-result">
    <div class="disputo-forum-search-badge">
        <span class="badge badge-info"><?php esc_html_e( 'Topic', 'disputo' ); ?></span>
    </div>
    <?php 
    if (has_post_thumbnail(bbp_get_topic_forum_id())) {
        $disputo_forum_img_id = get_post_thumbnail_id(bbp_get_topic_forum_id());
        $disputo_forum_img_array = wp_get_attachment_image_src($disputo_forum_img_id, 'thumbnail', true);
        $disputo_forum_img = $disputo_forum_img_array[0];
    ?> 
    <div class="disputo-forum-search-result-left">
        <a href="<?php bbp_forum_permalink(); ?>">
            <img src="<?php echo esc_url($disputo_forum_img); ?>" alt="<?php bbp_forum_title(); ?>" />
        </a>
    </div>
    <?php } ?>
    <div class="disputo-forum-search-result-right">
        <div class="disputo-forum-search-result-meta">
            <span class="bbp-topic-post-date"><?php bbp_topic_post_date( bbp_get_topic_id() ); ?></span>
            <a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink">#<?php bbp_topic_id(); ?></a>
        </div>
        <div class="disputo-forum-search-result-title">
            <?php do_action( 'bbp_theme_before_topic_title' ); ?>
            <h5>
              <a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a>
            </h5>
            <div class="disputo-forum-search-result-title-meta">
                <?php 
                if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) { 
                    esc_html_e( 'in group forum ', 'disputo' ); 
                } else { 
                    esc_html_e( 'in forum ', 'disputo' ); 
                }
                ?>
                <a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>
            </div>
		<?php do_action( 'bbp_theme_after_topic_title' ); ?>
	   </div>
    </div>
</div>