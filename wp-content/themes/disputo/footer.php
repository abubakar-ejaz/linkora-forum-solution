<?php
$disputo_footermessage = get_theme_mod('disputo_footermessage');
$disputo_enable_login_box = get_theme_mod('disputo_enable_login_box');
$disputo_show_reg_link = get_theme_mod('disputo_show_reg_link');
$disputo_show_pass_link = get_theme_mod('disputo_show_pass_link');
?>
<div class="clearfix"></div>
<?php do_action('disputo_before_footer'); ?>
<div class="clearfix"></div>
<footer id="disputo-footer">
    <?php if ( is_active_sidebar( 'disputofooterwidgets' ) ) { ?>
    <div class="container">
        <div id="footer-widgets">
            <?php dynamic_sidebar( 'disputofooterwidgets' ); ?>
        </div>
    </div>
    <?php } ?>  
    <div id="disputo-footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-7">
                    <?php if ($disputo_footermessage) { ?>
                    <?php echo wp_kses_post($disputo_footermessage); ?>
                    <?php } ?>
                </div>
                <div class="col-12 col-lg-5">
                    <?php get_template_part( 'templates/socialicons', 'template'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</footer>
<?php wp_footer(); ?>
</body>
</html>