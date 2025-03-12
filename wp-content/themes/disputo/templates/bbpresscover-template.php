<?php
$disputo_header_overlay = get_theme_mod('disputo_enable_overlay');
$disputo_header_img = '';
if (bbp_is_single_forum()) {
    $disputo_header_img = get_post_meta( get_queried_object_id(), 'disputo_cmb2_bg_image', true );
}
if (bbp_is_single_topic()) {
    $disputo_header_img = get_post_meta( bbp_get_topic_forum_id( get_queried_object_id() ), 'disputo_cmb2_bg_image', true );
}
if (bbp_is_single_user()) {
    $disputo_header_img = get_user_meta( bbp_get_displayed_user_id(), 'disputo_cmb2_user_cover_image', true );
}
if (empty($disputo_header_img)) {
    $disputo_header_img = get_theme_mod('disputo_bbpress_img');
}
?>
<div id="disputo-page-title-img" data-img="<?php echo esc_url($disputo_header_img); ?>"></div>
<?php if (($disputo_header_overlay) && (!empty($disputo_header_img)) && (!bbp_is_single_user())) { ?>
<div id="disputo-page-title-overlay"></div>
<?php } ?>