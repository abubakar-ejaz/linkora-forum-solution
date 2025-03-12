<?php	
/*
Template Name: FAQ
*/
?>
<?php get_header(); ?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php
$disputo_no_boxed = get_theme_mod('disputo_no_boxed'); 
$disputo_pagetitle = get_post_meta( get_queried_object_id(), 'disputo_cmb2_pagetitle', true );
$disputo_subtitle = get_post_meta( get_queried_object_id(), 'disputo_cmb2_subtitle', true );
?>
    <?php get_template_part( 'templates/cover', 'template'); ?>
    <?php if ((get_the_title()) && ($disputo_pagetitle != 'no')) { ?>
        <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
        <h1>  
        <?php the_title(); ?>    
        </h1>    
        <?php if (!empty($disputo_subtitle)) { ?>
        <p><?php echo stripslashes(esc_attr($disputo_subtitle)); ?></p>
        <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>
<main id="disputo-faq-page" class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class="<?php if (($disputo_pagetitle == 'no') || (!get_the_title())) { ?>nomargin<?php } ?> <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">
        <aside class="disputo-faq-left">
            <?php 
            if ( function_exists( 'disputo_faq_menu' ) ) {
                disputo_faq_menu();
            } ?>
            <?php if ( is_active_sidebar( 'disputo_faq_sidebar' ) ) { dynamic_sidebar( 'disputo_faq_sidebar' ); } ?>
            <div class="clearfix"></div>
        </aside>
            <div class="disputo-faq-right">
<?php 
if ( function_exists( 'disputo_faq_content' ) ) {
    the_content();
    disputo_faq_search();
    disputo_faq_content();
} else {
    the_content();
} ?> 
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
</main>
<?php endwhile; ?> 
<?php get_footer(); ?>