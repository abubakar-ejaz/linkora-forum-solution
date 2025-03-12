<?php $disputo_fb_color_scheme = get_theme_mod('disputo_fb_color_scheme', 'light'); ?>
<?php $disputo_fb_max = get_theme_mod('disputo_fb_max', 5); ?>
<?php $disputo_fb_order = get_theme_mod('disputo_fb_order', 'social'); ?>
<?php $disputo_fb_title = get_theme_mod('disputo_fb_title'); ?>
<div id="disputo-facebook-comments">
    <?php if (!empty($disputo_fb_title)) { ?>
    <h3><?php echo esc_html($disputo_fb_title); ?></h3>
    <?php } ?>
    <div class="disputo-facebook-comments">
    <div id="fb-root"></div>
    <div class="fb-comments" data-href="<?php esc_url(the_permalink()); ?>" data-numposts="<?php echo esc_attr($disputo_fb_max); ?>" data-colorscheme="<?php echo esc_attr($disputo_fb_color_scheme); ?>" data-width="100%" data-order-by="<?php echo esc_attr($disputo_fb_order); ?>"></div>
    </div>
</div>