<?php get_header(); ?>
<?php 
$disputo_blog_sub_title = get_theme_mod('disputo_blog_subtitle');
$disputo_no_boxed = get_theme_mod('disputo_no_boxed');
?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
    <?php get_template_part( 'templates/cover', 'template'); ?> 
    <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
        <h1>
    <?php
if ( is_home() && ! is_front_page() ) {
    single_post_title();
} else { 
    esc_html_e( 'Blog', 'disputo' ); 
} 
    ?>
        </h1>
        <?php if (!empty($disputo_blog_sub_title)) { ?>
        <p><?php echo stripslashes(esc_html($disputo_blog_sub_title)); ?></p>
        <?php } ?>
        </div>
    </div>
</div>
<main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class="<?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">
        <div class="disputo-page-left <?php if ( !is_active_sidebar( 'disputo_sidebar' ) ) { ?>disputo-page-full<?php } ?>"> 
            <div class="disputo-masonry-grid">
                <div class="disputo-two-columns" data-columns>
            <?php while(have_posts()) : the_post(); ?>
            <?php get_template_part( 'templates/masonry', 'template'); ?>
            <?php endwhile; ?>
                </div>
            </div>
            <?php if ( (get_next_posts_link()) || (get_previous_posts_link())) : ?>
                <div class="disputo-pager">
                    <?php disputo_pagination(); ?>
                </div> 
                <div class="clearfix"></div>    
            <?php endif; ?> 
        </div>
        <?php if ( is_active_sidebar( 'disputo_sidebar' ) ) { ?>
        <aside class="disputo-page-right">
            <?php dynamic_sidebar( 'disputo_sidebar' ); ?>
        </aside>
        <?php } ?>
        <div class="clearfix"></div> 
    </div>
    </div>
</main>
<?php get_footer(); ?>