<?php get_header(); ?>
<?php $disputo_no_boxed = get_theme_mod('disputo_no_boxed'); ?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'templates/bbpresscover', 'template'); ?>
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
        <?php the_content(); ?>
    </div>
    </div>
</main>
<?php endwhile; ?> 
<?php get_footer(); ?>