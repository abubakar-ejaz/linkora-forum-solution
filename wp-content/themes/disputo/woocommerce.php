<?php get_header(); ?>
<?php 
$disputo_woocommerce_sidebar = get_theme_mod('disputo_woocommerce_sidebar', 1);
$disputo_no_boxed = get_theme_mod('disputo_no_boxed');
?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
<?php if ( have_posts() ) : ?>
    <?php get_template_part( 'templates/woocover', 'template'); ?>
    <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
            <h1>
            <?php
            if(is_product()) {
                the_title();
            } else {
                woocommerce_page_title();
            } ?>
            </h1>
            <?php woocommerce_breadcrumb(); ?>   
        </div>
    </div>
</div>
<main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class="<?php if (!get_the_title()) { ?>nomargin<?php } ?> <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">      
        <?php if (($disputo_woocommerce_sidebar) && (!is_product()) && ( is_active_sidebar( 'disputo_woo_sidebar' ) )) { ?>
        <div class="disputo-page-left">    
        <?php } ?>    
        <?php woocommerce_content(); ?>    
        <div class="clearfix"></div>
        <?php if (($disputo_woocommerce_sidebar) && (!is_product()) && ( is_active_sidebar( 'disputo_woo_sidebar' ) )) { ?>  
        </div>
        <aside class="disputo-page-right">
            <?php dynamic_sidebar( 'disputo_woo_sidebar' ); ?>
        </aside>
        <div class="clearfix"></div>
        <?php } ?> 
    </div>
    </div>
</main>
<?php endif; ?>
<?php get_footer(); ?>