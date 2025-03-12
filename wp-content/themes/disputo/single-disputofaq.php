<?php get_header(); ?>
<?php
$disputo_enable_sharing = get_theme_mod('disputo_enable_sharing');
$disputo_no_boxed = get_theme_mod('disputo_no_boxed'); 
?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
<?php if ( have_posts() ) while ( have_posts() ) : the_post();
$disputo_answer = get_post_meta( get_queried_object_id(), 'disputo_cmb2_answer', true );
?>
<?php get_template_part( 'templates/cover', 'template'); ?>     
    <?php if (get_the_title()) { ?>
        <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
        <?php the_title('<h1>','</h1>'); ?>
        </div>
    </div>
    <?php } ?>
</div>
<main class="disputo-main-container">
    <div class="container">
        <div id="disputo-main-inner" class="<?php if (!get_the_title()) { ?>nomargin<?php } ?> <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">
            <div class="disputo-page-left <?php if ( !is_active_sidebar( 'disputo_faq_sidebar' ) ) { ?>disputo-page-full<?php } ?>"> 
                <article class="disputo-post-content">    
                    <?php echo wp_kses_post(wpautop($disputo_answer)); ?>
                    <div class="clearfix"></div>    
                </article>           
                <?php 
if (( $disputo_enable_sharing ) && ( function_exists( 'disputo_social_media_buttons' ))) {   
    disputo_social_media_buttons();
}
                ?>
                <div class="clearfix"></div>
            </div>
        <?php if ( is_active_sidebar( 'disputo_faq_sidebar' ) ) { ?>
        <aside class="disputo-page-right">
            <?php dynamic_sidebar( 'disputo_faq_sidebar' ); ?>
        </aside>
        <?php } ?>
        <div class="clearfix"></div>
        </div>
    </div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>