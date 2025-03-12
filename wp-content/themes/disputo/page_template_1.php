<?php	
/*
Template Name: Page - Sidebar
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
$disputo_hide_featured = get_post_meta( get_queried_object_id(), 'disputo_cmb2_hide_featured', true );    
?>
<?php get_template_part( 'templates/cover', 'template'); ?>    
    <?php if ((get_the_title()) && ($disputo_pagetitle != 'no')) { ?>
        <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
        <?php the_title('<h1>','</h1>'); ?>
        <?php if (!empty($disputo_subtitle)) { ?>
        <p><?php echo stripslashes(esc_attr($disputo_subtitle)); ?></p>
        <?php } ?>
        </div>
    </div>
    <?php } ?>
</div>
<main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class="<?php if (($disputo_pagetitle == 'no') || (!get_the_title())) { ?>nomargin<?php } ?> <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">
        <div class="disputo-page-left"> 
            <?php 
if ((has_post_thumbnail()) && ($disputo_hide_featured != 'yes')) {
$disputo_post_img_id = get_post_thumbnail_id();
$disputo_post_img_array = wp_get_attachment_image_src($disputo_post_img_id, 'full', true);
$disputo_post_img = $disputo_post_img_array[0];
?>     
<div class="disputo-featured-img page-featured">
    <img src="<?php echo esc_url($disputo_post_img); ?>" alt="<?php the_title_attribute(); ?>" />
</div>
<?php } ?>         
<?php the_content(); ?>
<?php wp_link_pages( array(
	'before'      => '<div class="disputo-page-links"><span class="disputo-page-links-desc">' . esc_html__( 'Pages:', 'disputo' ) . '</span>',
	'after'       => '</div>',
    'link_before' => '<span>',
	'link_after'  => '</span>'
	) );
?>
    <div class="clearfix"></div>
    <?php comments_template(); ?>
        </div>
        <aside class="disputo-page-right">
            <?php if ( is_active_sidebar( 'disputo_page_sidebar' ) ) { dynamic_sidebar( 'disputo_page_sidebar' ); } ?>
        </aside>
        <div class="clearfix"></div>
    </div>
    </div>
</main>
<?php endwhile; ?> 
<?php get_footer(); ?>