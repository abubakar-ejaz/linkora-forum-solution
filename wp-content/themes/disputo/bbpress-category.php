<?php get_header(); ?>

<?php 
$disputo_bbpress_forum_sidebar = get_theme_mod('disputo_bbpress_forum_sidebar');
$disputo_bbpress_topic_sidebar = get_theme_mod('disputo_bbpress_topic_sidebar', 1);
$disputo_bbpress_search_sidebar = get_theme_mod('disputo_bbpress_search_sidebar', 1);
$disputo_bbpress_search = get_theme_mod('disputo_bbpress_search');
$disputo_bbpress_signature = get_theme_mod('disputo_bbpress_signature');
$disputo_bbpress_header_signature = get_theme_mod('disputo_bbpress_header_signature');
$disputo_no_boxed = get_theme_mod('disputo_no_boxed'); 


?>


<div id="header-wrapper">
    <header>
        <?php get_template_part('templates/header', 'template'); ?>
    </header>
	<div id="disputo-page-title-img" data-img="https://linkora.ai/wp-content/uploads/2025/02/global-1compres.png" style="background-image: url(&quot;https://linkora.ai/wp-content/uploads/2025/02/global-1compres.png&quot;);"></div>
	<div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">

            <?php the_title('<h1>','</h1>'); ?>
            <?php if (bbp_is_single_forum()) { ?>
            <p><?php bbp_forum_content( get_the_id() ); ?></p> 
            <?php } ?>
            <?php if (bbp_is_single_user() && ($disputo_bbpress_signature) && ($disputo_bbpress_header_signature))  { ?>
            <?php $disputo_signature = get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_forum_signature', true ); ?>
            <?php if ($disputo_signature) { ?>
            <p class="disputo-page-subtitle"><?php echo wp_kses_post($disputo_signature); ?></p> 
            <?php } ?>
            <?php } ?>
<!-- 			
             if ( ($disputo_bbpress_search && !bbp_is_single_user()) || (bbp_allow_search() && bbp_is_search()) ) { ?>
            <div id="disputo-header-search">
             get_template_part( 'templates/bbpresslg', 'template'); ?>
            </div>
      } ?>
			 -->
        </div>
    </div>
	</div>

	<main class="disputo-main-container">
    <div class="container">
    <div class="city-list">
        <?php echo do_shortcode('[list_cities_for_forums]'); ?>
    </div>
		</div>
</main>
<?php get_footer(); ?>