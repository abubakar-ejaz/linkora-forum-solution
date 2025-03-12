<?php
$disputo_selector_pseudo_query = $instance['b_section']['posts'];
$disputo_random_id = rand();

// Process the post selector pseudo query.
$disputo_processed_query = siteorigin_widget_post_selector_process_query( $disputo_selector_pseudo_query . '&meta_key=_thumbnail_id');

// Use the processed post selector query to find posts.
$disputo_query_result = new WP_Query( $disputo_processed_query );
?>

<?php if (!empty($instance['a_section']['heading'])) { ?>
<div class="disputo-widget-title">
    <<?php echo esc_attr($instance['a_section']['headinglevel']); ?>><span><?php echo esc_attr($instance['a_section']['heading']); ?></span></<?php echo esc_attr($instance['a_section']['headinglevel']); ?>>
</div>
<?php } ?>

<div class="disputo-carousel-container disputo-bg-loader">   
    <div id="disputo-post-carousel-<?php echo esc_attr($disputo_random_id) ?>" class="disputo-slider">
<?php while($disputo_query_result->have_posts()) : $disputo_query_result->the_post(); ?>
<div <?php post_class(); ?>>
    <?php
    $disputo_post_type = get_post_type(get_the_id());
    $disputo_thumb_id = get_post_thumbnail_id();
    $disputo_thumb_url_array = wp_get_attachment_image_src($disputo_thumb_id, $instance['c_section']['size'], true);
    $disputo_thumb_url = $disputo_thumb_url_array[0];
    ?>
    <a class="disputo-slider-img" href="<?php esc_url(the_permalink()); ?>">
        
        <?php if ($disputo_post_type == "forum") { ?>
        <ul class="disputo-slider-forum-meta">
            <li><span class="badge badge-primary"><?php esc_html_e( 'Topics:', 'disputo') ?> <?php echo esc_html(bbp_get_forum_topic_count( get_the_id(), true )); ?></span></li>
            <li><span class="badge badge-info"><?php esc_html_e( 'Replies:', 'disputo') ?> <?php echo esc_html(bbp_get_forum_reply_count( get_the_id(), true )); ?></span></li>
        </ul>
        <?php } ?>      
        <?php if ($disputo_post_type == "product") { ?>
        <?php global $post, $product; ?>
        <ul class="disputo-slider-forum-meta">
        <?php if ( $product->is_on_sale() ) {
                echo apply_filters( 'woocommerce_sale_flash', '<li><span class="badge badge-success">' . esc_html__( 'Sale!', 'disputo' ) . '</span></li>', $post, $product );
            }
        ?>
            <li><span class="badge badge-primary"><?php echo $product->get_price_html(); ?></span></li>
        </ul>    
        <?php } ?>     
        <img src="<?php echo esc_url($disputo_thumb_url); ?>" alt="<?php the_title(); ?>" />   
    </a>
    <div class="disputo-slider-desc">
        <?php if ($disputo_post_type == "post") { ?>
        <span class="disputo-slider-date"><?php the_time(get_option('date_format')); ?></span>
        <?php } ?>
        <<?php echo esc_attr($instance['b_section']['headinglevel']); ?> class="disputo-slider-title"><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></<?php echo esc_attr($instance['b_section']['headinglevel']); ?>>
        <?php if ($disputo_post_type != "forum") { ?>
        <?php the_excerpt(); ?>
        <?php } ?>
        <?php if ($disputo_post_type == "forum") { ?>    
        <p><?php echo esc_html(bbp_get_forum_content( get_the_id() )); ?></p> 
        <?php } ?>
    </div>
</div>       
<?php endwhile; ?>        
    </div>
</div>
<script type="text/javascript">
(function ($) {
"use strict";    
$(document).ready(function () {
    $('#disputo-post-carousel-<?php echo esc_attr($disputo_random_id) ?>').slick({
        <?php if ($instance['c_section']['autoplay'] == 'true') { ?>
        autoplay: true,
        autoplaySpeed: <?php echo esc_js($instance['c_section']['duration']); ?>000,
        <?php } ?>
        slidesToScroll: 1,
        adaptiveHeight: true,
        slidesToShow: 1,
        <?php if ( is_rtl() ) { ?>
        rtl: true,
        <?php } ?>
        arrows: true,
        dots : false,
        fade: <?php if ($instance['c_section']['fade'] == 'true') { ?>true<?php } else { ?>false<?php } ?>
    });
});
$(window).on('load', function () {
    $('#disputo-post-carousel-<?php echo esc_js($disputo_random_id); ?>').css('opacity', '1');
    $('#disputo-post-carousel-<?php echo esc_js($disputo_random_id); ?>').parent().removeClass('disputo-bg-loader');
});     
})(jQuery);        
</script>
<?php wp_reset_postdata(); ?>
<?php if(!empty($instance['d_section']['viewmore'])) { ?>
<div class="disputo-view-more">
    <a class="btn btn-primary" href="<?php echo sow_esc_url($instance['d_section']['viewmore']); ?>"><?php echo esc_attr($instance['d_section']['buttontext']); ?> <i class="fa fa-long-arrow-right"></i></a>
</div>    
<?php } ?>    