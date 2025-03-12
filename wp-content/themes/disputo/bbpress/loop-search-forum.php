<?php

/**
 * Search Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="disputo-forum-search-result">
    <div class="disputo-forum-search-badge">
        <span class="badge badge-primary"><?php esc_html_e( 'Forum', 'disputo' ); ?></span>
    </div>
    <?php 
    if (has_post_thumbnail(bbp_get_forum_id())) {
        $disputo_forum_img_id = get_post_thumbnail_id(bbp_get_forum_id());
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
            <span class="bbp-forum-post-date"><?php printf( esc_html__( 'Last updated %s', 'disputo' ), bbp_get_forum_last_active_time() ); ?></span>
            <a href="<?php bbp_forum_permalink(); ?>" class="bbp-forum-permalink">#<?php bbp_forum_id(); ?></a>
        </div>
        <div class="disputo-forum-search-result-title">
            <?php do_action( 'bbp_theme_before_forum_title' ); ?>
            <h5><a href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a></h5>
            <?php do_action( 'bbp_theme_after_forum_title' ); ?>
	   </div>
    </div>
</div>