<?php 
$heading_check = 0;
if (empty($heading)) {
    $heading = bbp_get_forum_title($forumid);
    $heading_check = 1;
}
$disputo_forum_bg = '';
if (has_post_thumbnail($forumid)) {
    $disputo_forum_img_id = get_post_thumbnail_id($forumid);
    $disputo_forum_img_array = wp_get_attachment_image_src($disputo_forum_img_id, 'large', true);
    $disputo_forum_img = $disputo_forum_img_array[0];
    $disputo_forum_bg = 'background-image:url(' . $disputo_forum_img . ')';
}
?> 
<div class="disputo-forum-widget-title <?php if (!empty($disputo_forum_bg)) { echo 'has-bg'; } ?>" style="<?php echo $disputo_forum_bg; ?>">
    <div class="disputo-forum-widget-overlay"></div>
    <div class="disputo-forum-widget-left">
        <<?php echo esc_attr($headinglevel); ?>><?php echo esc_attr($heading); ?></<?php echo esc_attr($headinglevel); ?>>
        <?php if ($heading_check == 1) { ?>
        <p class="disputo-forum-widget-desc"><?php bbp_forum_content($forumid); ?></p>
        <?php } ?>
    </div>
    <div class="disputo-forum-widget-right">
        <ul class="disputo-forum-widget-statistics">
            <li class="disputo-viewall-statistic"><a href="<?php echo esc_url(bbp_get_forum_permalink($forumid)); ?>" class="btn btn-sm btn-info"><?php esc_html_e( 'View All', 'disputo' ); ?></a></li>
            <li class="disputo-reply-statistic" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e( 'Replies', 'disputo' ); ?>"><span><i class="fa fa-comments"></i> <?php bbp_show_lead_topic() ? bbp_forum_reply_count($forumid) : bbp_forum_post_count($forumid); ?></span></li>
            <li class="disputo-topic-statistic" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e( 'Topics', 'disputo' ); ?>"><span><i class="fa fa-comment"></i> <?php bbp_forum_topic_count($forumid); ?></span></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<div class="disputo-forum-widget-wrapper">        
<?php
$disputo_forum_query = array(
    'post_type' => bbp_get_topic_post_type(),
    'post_parent' => $forumid, 
    'meta_key' => '_bbp_last_active_time',
    'meta_type' => 'DATETIME',
    'orderby' => 'meta_value', 
    'order' => 'DESC',
    'max_num_pages' => '1',
    'posts_per_page' => $maxtopics
);
if (bbp_has_topics($disputo_forum_query)) {
    bbp_get_template_part( 'bbpress/loop', 'topics' );
}
?>
</div>    