<?php get_header(); ?>
<?php
$disputo_meta = get_theme_mod('disputo_removemeta', 1);
$disputo_enable_sharing = get_theme_mod('disputo_enable_sharing');
$disputo_like_dislike = get_option('disputo_like_dislike');
$disputo_enable_author_box = get_theme_mod('disputo_enable_author_box');
$disputo_activate_fb_comments = get_theme_mod('disputo_activate_fb_comments');
$disputo_no_boxed = get_theme_mod('disputo_no_boxed'); 
?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
<?php if ( have_posts() ) while ( have_posts() ) : the_post();
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
        <div class="disputo-page-left <?php if ( !is_active_sidebar( 'disputo_sidebar' ) ) { ?>disputo-page-full<?php } ?>"> 
        <?php do_action('disputo_before_single_post'); ?>
<article class="disputo-post-content"> 
    
<?php 
if ((has_post_thumbnail()) && ($disputo_hide_featured != 'yes')) {
$disputo_post_img_id = get_post_thumbnail_id();
$disputo_post_img_array = wp_get_attachment_image_src($disputo_post_img_id, 'full', true);
$disputo_post_img = $disputo_post_img_array[0];
?>     
<div class="disputo-featured-img">
    <img src="<?php echo esc_url($disputo_post_img); ?>" alt="<?php the_title_attribute(); ?>" />
</div>
<?php } ?> 
    
<div class="disputo-post-content-inner">   
<?php the_content(); ?>
<div class="clearfix"></div> 
<?php wp_link_pages( array(
	'before'      => '<div class="disputo-page-links"><span class="disputo-page-links-desc">' . esc_html__( 'Pages:', 'disputo' ) . '</span>',
	'after'       => '</div>',
    'link_before' => '<span>',
	'link_after'  => '</span>'
	) );
?> 
<?php
    if((!empty($disputo_like_dislike)) && ($disputo_like_dislike['v-switch-posts'] != 'off') && (function_exists('disputo_render_for_posts'))) {        
        echo disputo_render_for_posts(true,true);
    }
?>  
    <?php 
if (( $disputo_enable_sharing ) && ( function_exists( 'disputo_social_media_buttons' ))) {   
    disputo_social_media_buttons();
}
    ?>
    </div> 
    <?php if ($disputo_meta) { ?>    
    <div class="disputo-meta">
        <div class="disputo-meta-date">
            <i class="fa fa-clock-o"></i><?php the_time(get_option('date_format')); ?>
        </div>
        <?php if( has_category() ) { ?> 
        <div class="disputo-meta-category">
            <i class="fa fa-folder-open"></i><?php echo the_category(', '); ?>
        </div> 
        <?php } ?>
        <?php if( has_tag() ) { ?> 
        <div class="disputo-meta-tags">
        <i class="fa fa-tags"></i><?php echo the_tags('',', ', ''); ?>
        </div>
        <?php } ?>
    </div>   
    <?php } ?>
</article> 
            
<?php    
if ( $disputo_enable_author_box ) {   
    get_template_part( 'templates/authorbox', 'template');
}    
            
do_action('disputo_after_single_post');             
       
?>
<?php
if (( $disputo_activate_fb_comments ) && ( function_exists( 'disputo_fbcomments' ))) {
    disputo_fbcomments();
} 
?>            
<?php comments_template(); ?>
        </div>      
        <?php if ( is_active_sidebar( 'disputo_sidebar' ) ) { ?>
        <aside class="disputo-page-right">
            <?php dynamic_sidebar( 'disputo_sidebar' ); ?>
        </aside>
        <div class="clearfix"></div>
        <?php } ?>
    </div>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>