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
$disputo_processed_query = siteorigin_widget_post_selector_process_query( $disputo_selector_pseudo_query . $verified_filter );

// Use the processed post selector query to find posts.
$disputo_query_result = new WP_Query( $disputo_processed_query);
?>

<?php if (!empty($instance['a_section']['heading'])) { ?>
<div class="disputo-widget-title">
    <<?php echo esc_attr($instance['a_section']['headinglevel']); ?>><span><?php echo esc_attr($instance['a_section']['heading']); ?></span></<?php echo esc_attr($instance['a_section']['headinglevel']); ?>>
</div>
<?php } ?>
<?php
$grid_style = '';
if (($instance['b_section']['columns'] == 'disputo-four-columns')) {
    $grid_style = 'small-grid';
}
?>
<div class="disputo-masonry-grid <?php echo esc_html($grid_style); ?>">
    <div class="<?php echo esc_attr($instance['b_section']['columns']); ?>" data-columns>    
<?php while($disputo_query_result->have_posts()) : $disputo_query_result->the_post(); ?>
<?php $disputo_post_type = get_post_type(get_the_id()); ?>        
<?php
if ($disputo_post_type == "forum") {
    if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-one-column')) {
        get_template_part( 'templates/xsforum', 'template');
    } else {
        get_template_part( 'templates/forum', 'template');
    }
} elseif ($disputo_post_type == "topic") {
    if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-one-column')) {
        get_template_part( 'templates/xstopic', 'template');
    } else {
        get_template_part( 'templates/topic', 'template');
    }
        
} elseif ($disputo_post_type == "reply") {
    if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-one-column')) {
        get_template_part( 'templates/xsreply', 'template');
    } else {
        get_template_part( 'templates/reply', 'template');
    }
} elseif ($disputo_post_type == "product") {
    if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-one-column')) {
        get_template_part( 'templates/woo/xsproduct', 'template');
    } else {
        get_template_part( 'templates/woo/product', 'template');
    }
} else {
    if (($instance['b_section']['columns'] == 'disputo-four-columns') || ($instance['b_section']['columns'] == 'disputo-one-column')) {
        get_template_part( 'templates/xsmasonry', 'template');
    } else {
        get_template_part( 'templates/masonry', 'template');
    }
}
?>
<?php endwhile; ?>
    </div>
</div>
<?php wp_reset_postdata(); ?>

<?php if(!empty($instance['c_section']['viewmore'])) { ?>
<div class="disputo-view-more">
    <a class="btn btn-primary" href="<?php echo sow_esc_url($instance['c_section']['viewmore']); ?>"><?php echo esc_attr($instance['c_section']['buttontext']); ?> <i class="fa fa-long-arrow-right"></i></a>
</div>    
<?php } ?>