<?php
$disputo_header_overlay = get_theme_mod('disputo_enable_overlay');
$disputo_shop_cover_img = '';
if (is_singular('product')) {
    $disputo_shop_cover_img = get_post_meta( get_queried_object_id(), 'disputo_cmb2_bg_image', true );
}
if (is_tax( 'product_cat' )) {
    $disputo_term_id = get_queried_object()->term_id;
    $disputo_shop_cover_img = get_term_meta( $disputo_term_id, 'disputo_cmb2_cat_cover_image', true );
}
if (empty($disputo_shop_cover_img)) {
    $disputo_shop_cover_img = get_theme_mod('disputo_shop_cover_img');
}
?>
<div id="disputo-page-title-img" data-img="<?php echo esc_url($disputo_shop_cover_img); ?>"></div>
<?php if (($disputo_header_overlay) && (!empty($disputo_shop_cover_img))) { ?>
<div id="disputo-page-title-overlay"></div>
<?php } ?>