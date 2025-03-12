<?php	
/*
Template Name: Blog - 2 Column
*/
?>
<?php get_header(); ?>
<?php
$disputo_paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$disputo_post_per_page = get_theme_mod( 'disputo_blog_2_at_most', 8 );
$disputo_custom_query = new WP_Query( 
    array('post_type' => 'post', 'posts_per_page' => $disputo_post_per_page, 'paged' => $disputo_paged) 
);
?>
<?php
$disputo_no_boxed = get_theme_mod('disputo_no_boxed'); 
$disputo_pagetitle = get_post_meta( get_queried_object_id(), 'disputo_cmb2_pagetitle', true );
$disputo_subtitle = get_post_meta( get_queried_object_id(), 'disputo_cmb2_subtitle', true );
?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
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
        <div class="disputo-masonry-grid">
            <div class="disputo-two-columns" data-columns>
                <?php while($disputo_custom_query->have_posts()) : $disputo_custom_query->the_post(); ?>
                <?php get_template_part( 'templates/masonry', 'template'); ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php if ( $disputo_custom_query->max_num_pages > 1 ) : ?>
            <div class="disputo-pager">
                <?php disputo_custom_pagination($disputo_custom_query); ?>
            </div> 
            <div class="clear"></div>    
        <?php endif; ?> 
        <?php wp_reset_postdata(); ?>
        <div class="clearfix"></div>
    </div>
    </div>
</main>
<?php get_footer(); ?>