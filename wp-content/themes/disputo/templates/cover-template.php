<?php
$disputo_header_overlay = get_theme_mod('disputo_enable_overlay');
$disputo_header_img = '';
if (is_single() || is_page()) {
    $disputo_header_img = get_post_meta( get_queried_object_id(), 'disputo_cmb2_bg_image', true );
}
if (is_category()) {
    $disputo_term_id = get_queried_object()->term_id;
    $disputo_header_img = get_term_meta( $disputo_term_id, 'disputo_cmb2_cat_cover_image', true );
}
if (is_author()) {
    $disputo_header_img = get_user_meta( get_the_author_meta('ID'), 'disputo_cmb2_user_cover_image', true );
}
if (empty($disputo_header_img)) {
    $disputo_header_img = get_theme_mod('disputo_header_img');
}
?>
<div id="disputo-page-title-img" data-img="<?php echo esc_url($disputo_header_img); ?>"></div>
<?php if (($disputo_header_overlay) && (!empty($disputo_header_img)) && (!is_author())) { ?>
<div id="disputo-page-title-overlay"></div>
<?php } ?>