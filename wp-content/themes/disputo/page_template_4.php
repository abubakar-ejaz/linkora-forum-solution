<?php	
/*
Template Name: User Search
*/
?>
<?php get_header(); ?>
<?php $disputo_search_query = get_query_var('bb_user'); ?>
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
        <?php if (!empty($disputo_search_query)) { ?>
        <p><?php echo esc_html__( 'Search Results for:', 'disputo' ) . ' ' . $disputo_search_query; ?></p>
        <?php } elseif (!empty($disputo_subtitle)) { ?>
        <p><?php echo stripslashes(esc_attr($disputo_subtitle)); ?></p>
        <?php } ?>    
        <div id="disputo-header-search">
            <?php get_template_part( 'templates/usersearchlg', 'template'); ?>
        </div>    
        </div>
    </div>
<?php } ?>
</div>    
<main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class="<?php if (($disputo_pagetitle == 'no') || (!get_the_title())) { ?>nomargin<?php } ?> <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">      
        <?php the_content(); ?>
        <div class="clearfix"></div>
    </div>
    </div>
</main>
<?php endwhile; ?> 
<?php get_footer(); ?>