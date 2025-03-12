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
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'templates/bbpresscover', 'template'); ?>
    <?php if (get_the_title()) { ?>
        <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
<?php

// end Category Page to Show Cities
// Function to generate breadcrumbs for forums, topics, and location taxonomy
function get_universal_forum_breadcrumbs() {
    $breadcrumbs = [];
    $breadcrumbs[] = '<a href="' . home_url('/') . '">Home</a>';

    // Check if it's a forum archive, single forum, single topic, or location taxonomy
    if (is_post_type_archive('forum') || is_singular('forum') || is_singular('topic') || is_tax('location')) {
        // Get the current term or post object
        if (is_tax('location')) {
            // Handle location taxonomy pages
            $term = get_queried_object();
            $terms = [$term];
        } else {
            // Handle forum and topic pages
            $post_id = get_the_ID();

            // For topics, get the associated forum ID
            if (is_singular('topic')) {
                $forum_id = bbp_get_topic_forum_id($post_id);
                $post_id = $forum_id; // Use the forum ID to fetch location terms
            }

            // Get the forum object
            $forum = get_post($post_id);

            // Get the location terms associated with the forum or its parent
            if ($forum->post_parent) {
                // Get the parent forum category ID
                $parent_forum_id = $forum->post_parent;

                // Get the location terms associated with the parent forum category
                $terms = wp_get_post_terms($parent_forum_id, 'location', ['orderby' => 'parent', 'order' => 'ASC']);
            } else {
                // Get the location terms associated with the current forum
                $terms = wp_get_post_terms($post_id, 'location', ['orderby' => 'parent', 'order' => 'ASC']);
            }

            // If location terms exist, build the hierarchy
            if (!empty($terms)) {
                $locations = [];
                foreach ($terms as $term) {
                    if ($term->parent == 0) {
                        $locations[0] = $term; // Continent
                    } else {
                        $parent_term = get_term($term->parent, 'location');
                        if ($parent_term->parent == 0) {
                            $locations[1] = $term; // Country
                        } else {
                            $locations[2] = $term; // City
                        }
                    }
                }

                // Sort by hierarchy level and add to breadcrumbs
                ksort($locations);
                foreach ($locations as $location) {
                    $breadcrumbs[] = '<a href="' . get_term_link($location) . '">' . $location->name . '</a>';
                }
            }

            // Add the parent forum category after the city
            if ($forum->post_parent) {
                $parent_forum_title = get_the_title($forum->post_parent);
                $breadcrumbs[] = '<a href="' . get_permalink($forum->post_parent) . '">' . $parent_forum_title . '</a>';
            }
        }

        // Add forum link for single topics
        if (is_singular('topic')) {
            $forum_id = bbp_get_topic_forum_id(get_the_ID());
            $forum_title = get_the_title($forum_id);
            $breadcrumbs[] = '<a href="' . get_permalink($forum_id) . '">' . $forum_title . '</a>';
        }

        // Add current post title for single forums or topics
        if (is_singular('forum') || is_singular('topic')) {
            $breadcrumbs[] = get_the_title();
        }
    }

    // Join breadcrumbs with a separator
    return implode(' &raquo; ', $breadcrumbs);
}

// Display breadcrumbs
$breadcrumbs = get_universal_forum_breadcrumbs();
if ($breadcrumbs) {
    echo '<div class="disputo-breadcrumbs">' . $breadcrumbs . '</div>';
}
?>
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
    <?php } ?>
</div>
<main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class="<?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">    
        <?php if ((bbp_is_single_forum() || bbp_is_forum_archive()) && ($disputo_bbpress_forum_sidebar) && (is_active_sidebar( 'disputo_bbpress_forum_sidebar' ))) { ?>
        <div class="disputo-page-left"> 
        <?php } ?>
        <?php if ((bbp_is_single_topic() || bbp_is_topic_archive()) && ($disputo_bbpress_topic_sidebar) && (is_active_sidebar( 'disputo_bbpress_topic_sidebar' ))) { ?>
        <div class="disputo-page-left"> 
        <?php } ?>
        <?php if ((bbp_is_search()) && ($disputo_bbpress_search_sidebar) && (is_active_sidebar( 'disputo_bbpress_search_sidebar' ))) { ?>
        <div class="disputo-page-left"> 
        <?php } ?>    
        <?php the_content(); ?>  
        <?php if ((bbp_is_single_forum() || bbp_is_forum_archive()) && ($disputo_bbpress_forum_sidebar) && (is_active_sidebar( 'disputo_bbpress_forum_sidebar' ))) { ?>
        </div>
            <aside class="disputo-page-right">
                <?php dynamic_sidebar( 'disputo_bbpress_forum_sidebar' ); ?>
            </aside>
        <?php } ?> 
        <?php if ((bbp_is_single_topic() || bbp_is_topic_archive()) && ($disputo_bbpress_topic_sidebar) && (is_active_sidebar( 'disputo_bbpress_topic_sidebar' ))) { ?>
        </div>
            <aside class="disputo-page-right">
                <?php dynamic_sidebar( 'disputo_bbpress_topic_sidebar' ); ?>
            </aside>
        <?php } ?> 
        <?php if ((bbp_is_search()) && ($disputo_bbpress_search_sidebar) && (is_active_sidebar( 'disputo_bbpress_search_sidebar' ))) { ?>
        </div>
            <aside class="disputo-page-right">
                <?php dynamic_sidebar( 'disputo_bbpress_search_sidebar' ); ?>
            </aside>
        <?php } ?>     
    </div>
    </div>
</main>
<?php endwhile; ?> 
<?php get_footer(); ?>