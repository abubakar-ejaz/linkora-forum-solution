<?php get_header(); ?>
<?php $disputo_no_boxed = get_theme_mod('disputo_no_boxed'); ?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
    <?php get_template_part( 'templates/cover', 'template'); ?> 
    <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
        <h1><?php esc_html_e( '404 - Page not found', 'disputo' ); ?></h1>
        </div>
    </div>
</div>
<main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class=" <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">
            <p class="lead"><?php esc_html_e( 'You can search for the page you were looking for;', 'disputo'); ?></p>
            <div class="disputo-no-result-form">
                <?php get_search_form(); ?>
            </div>
            <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'or Return Home', 'disputo' ); ?></a>
        <div class="clearfix"></div>
    </div>
    </div>
</main>
<?php get_footer(); ?>