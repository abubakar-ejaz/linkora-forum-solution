<?php
$disputo_selector_pseudo_query = $instance['b_section']['posts'];
$disputo_verified = $instance['b_section']['verified'];
$disputo_random_id = rand();

// Process the post selector pseudo query.
$verified_filter = '';
if ($disputo_verified) {
    $users = get_users(array(
        'meta_key'     => 'disputo_verified_user',
        'meta_value'   => 'yes'
    ));
    foreach($users as $user) {
        $verified_filter .= $user->ID . ',';
    }
    $ids = rtrim($verified_filter, ',');
    $verified_filter = '&author=' . $ids;
}
$disputo_processed_query = siteorigin_widget_post_selector_process_query( $disputo_selector_pseudo_query . $verified_filter);

// Use the processed post selector query to find posts.
$disputo_query_result = new WP_Query( $disputo_processed_query );
?>

<?php if (!empty($instance['a_section']['heading'])) { ?>
<div class="disputo-widget-title">
    <<?php echo esc_attr($instance['a_section']['headinglevel']); ?>><span><?php echo esc_attr($instance['a_section']['heading']); ?></span></<?php echo esc_attr($instance['a_section']['headinglevel']); ?>>
</div>
<?php } ?>

<div class="disputo-post-list-wrapper">
    <?php while($disputo_query_result->have_posts()) : $disputo_query_result->the_post(); ?>
    <?php $disputo_post_type = get_post_type(get_the_id()); ?>
    <div class="disputo-post-list">
        <?php if (has_post_thumbnail()) { ?>
        <?php
        $disputo_thumb_id = get_post_thumbnail_id();
        $disputo_thumb_url_array = wp_get_attachment_image_src($disputo_thumb_id, 'thumbnail', true);
        $disputo_thumb_url = $disputo_thumb_url_array[0];
        ?>
        <div class="disputo-post-list-left">
            <a href="<?php esc_url(the_permalink()); ?>">
                <img src="<?php echo esc_url($disputo_thumb_url); ?>" alt="<?php the_title(); ?>" />   
            </a>
        </div>
        <?php } elseif ($disputo_post_type == "reply") { ?>
        <div class="disputo-post-list-left">
            <?php $disputo_user_info = get_userdata( bbp_get_reply_author_id() ); ?>
            <a href="<?php bbp_user_profile_url(bbp_get_reply_author_id()); ?>" data-toggle="tooltip" data-placement="left" title="<?php echo esc_html($disputo_user_info->user_login); ?>">
            <?php echo get_avatar( bbp_get_reply_author_id(), 80 ); ?>
            </a>
        </div>
        <?php } ?>
        <div class="disputo-post-list-right">
            <p><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></p>  
            <?php if ($disputo_post_type == "post") { ?>
            <div class="disputo-post-list-info">
            <i class="fa fa-clock-o"></i><a href="<?php esc_url(the_permalink()); ?>"><?php the_time(get_option('date_format')); ?></a>
            </div>    
            <?php } elseif ($disputo_post_type == "forum") { ?>
            <div class="disputo-post-list-meta">
            <span>
                <?php esc_html_e( 'Topics:', 'disputo') ?> <strong><?php echo esc_html(bbp_get_forum_topic_count( get_the_id(), true )); ?></strong>
            </span>   
            <span>
            <?php esc_html_e( 'Replies:', 'disputo') ?> <strong><?php echo esc_html(bbp_get_forum_reply_count( get_the_id(), true )); ?></strong>
            </span>
            </div>
            <?php } elseif ($disputo_post_type == "topic") { ?>
            <div class="disputo-post-list-meta">
            <span>
                <?php esc_html_e( 'Voices:', 'disputo') ?> <strong><?php echo esc_html(bbp_get_topic_voice_count( get_the_id(), true )); ?></strong>
            </span> 
            <span>
                <?php esc_html_e( 'Replies:', 'disputo') ?> <strong><?php echo esc_html(bbp_get_topic_reply_count( get_the_id(), true )); ?></strong>
            </span> 
            </div>
            <?php } elseif ($disputo_post_type == "reply") { ?>
            <div class="disputo-post-list-info">
            <i class="fa fa-clock-o"></i><a href="<?php esc_url(the_permalink()); ?>"><?php the_time(get_option('date_format')); ?></a>
            </div>  
            <?php } elseif ($disputo_post_type == "product") { ?>
            <?php global $product; ?>
            <div class="disputo-post-list-meta">
            <span>
            <?php echo $product->get_price_html(); ?>
            </span>
            </div>    
            <?php } ?>
        </div>
    </div>
    <?php endwhile; ?> 
</div>
<?php wp_reset_postdata(); ?>