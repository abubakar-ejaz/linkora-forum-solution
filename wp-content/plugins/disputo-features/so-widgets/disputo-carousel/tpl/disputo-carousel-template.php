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
    <<?php echo esc_attr($instance['a_section']['headinglevel']); ?> class="disputo-carousel-title"><span><?php echo esc_attr($instance['a_section']['heading']); ?></span></<?php echo esc_attr($instance['a_section']['headinglevel']); ?>>
</div>
<?php } ?>

<div class="disputo-carousel-container">
    <?php if(!empty($instance['d_section']['viewmore'])) { ?>
<div class="disputo-carousel-view-more">
    <a href="<?php echo sow_esc_url($instance['d_section']['viewmore']); ?>"><?php echo esc_attr($instance['d_section']['buttontext']); ?></a>
</div>    
<?php } ?>
<?php
$carousel_style = '';
if (($instance['c_section']['columns'] == 'fourcolumns') || ($instance['c_section']['columns'] == 'fivecolumns')) {
    $carousel_style = 'small-carousel';
}
?>    
    <div id="disputo-post-carousel-<?php echo esc_attr($disputo_random_id) ?>" class="disputo-carousel <?php echo esc_html($carousel_style); ?>">
<?php while($disputo_query_result->have_posts()) : $disputo_query_result->the_post(); ?>
<?php
$disputo_post_type = get_post_type(get_the_id());
if ($disputo_post_type == "forum") {
    get_template_part( 'templates/xsforum', 'template');
} elseif ($disputo_post_type == "topic") {
    get_template_part( 'templates/xstopic', 'template');
} elseif ($disputo_post_type == "reply") {
    get_template_part( 'templates/xsreply', 'template');
} elseif ($disputo_post_type == "product") {
    get_template_part( 'templates/woo/xsproduct', 'template');
} else {
    get_template_part( 'templates/xsmasonry', 'template');
}
?>        
<?php endwhile; ?>        
    </div>
</div>
<?php wp_reset_postdata(); ?>      
<script type="text/javascript">
(function ($) {
"use strict";    
$(document).ready(function () {
    $('#disputo-post-carousel-<?php echo esc_attr($disputo_random_id) ?>').slick({
        infinite: false,
        slidesToScroll: 1,
        <?php if ( is_rtl() ) { ?>
        rtl: true,
        <?php } ?>
        arrows: true,
        dots : false,
        <?php if ($instance['c_section']['columns'] == 'onecolumn') { ?>
        adaptiveHeight: true,
        slidesToShow: 1
        <?php } else if ($instance['c_section']['columns'] == 'twocolumns') { ?>
        slidesToShow: 2,
        responsive: [{breakpoint: 576,settings: {slidesToShow: 1}}]
        <?php } else if ($instance['c_section']['columns'] == 'threecolumns') { ?>
        slidesToShow: 3,
        responsive: [{breakpoint: 992,settings: {slidesToShow: 2}},{breakpoint: 576,settings: {slidesToShow: 1}}]
        <?php } else if ($instance['c_section']['columns'] == 'fourcolumns') { ?>                        slidesToShow: 4,
        responsive: [{breakpoint: 1200,settings: {slidesToShow: 3}},{breakpoint: 992,settings: {slidesToShow: 2}},{breakpoint: 576,settings: {slidesToShow: 1}}]                     
        <?php } else { ?>
        slidesToShow: 5,
        responsive: [{breakpoint: 1440,settings: {slidesToShow: 4}},{breakpoint: 1200,settings: {slidesToShow: 3}},{breakpoint: 992,settings: {slidesToShow: 2}},{breakpoint: 576,settings: {slidesToShow: 1}}]
        <?php } ?>                                                                         
    });
    $('#disputo-post-carousel-<?php echo esc_attr($disputo_random_id) ?>').css('opacity', '1');
});
})(jQuery);        
</script>