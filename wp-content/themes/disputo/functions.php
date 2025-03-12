<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
require_once ( get_template_directory() . '/includes/functions.php' );
require_once ( get_template_directory() . '/includes/bs4navwalker.php' );
require_once ( get_template_directory() . '/includes/bs4pagination.php' );

/* IF KIRKI PLUGIN IS LOADED */
if ( class_exists( 'Kirki' ) ) {
    require_once ( get_template_directory() . '/includes/kirki.php' );
}

/* IF CMB2 PLUGIN IS LOADED */
if ( defined( 'CMB2_LOADED' ) ) {
    require_once ( get_template_directory() . '/includes/social-icons.php' );
    require_once ( get_template_directory() . '/includes/meta-boxes.php' );
}

/* IF bbPress PLUGIN IS LOADED */
if (class_exists( 'bbPress' )) {
    require_once ( get_template_directory() . '/includes/bbp-functions.php' );
}

/* IF WOOCOMMERCE PLUGIN IS LOADED */
if ( class_exists( 'woocommerce' ) ) {
    require_once ( get_template_directory() . '/includes/woo-functions.php' );
}
//fakhar Notifications
function send_bbpress_push_notification($post_id) {
    if (get_post_type($post_id) === 'topic' || get_post_type($post_id) === 'reply') {
        $title = get_the_title($post_id);
        $url = get_permalink($post_id);
        $message = 'New ' . get_post_type($post_id) . ' posted: ' . $title;

        // OneSignal API Integration
        $fields = array(
            'app_id' => 'f8f2fb3a-a333-4299-849a-e3a82b3533b5',
            'included_segments' => array('All'),
            'contents' => array('en' => $message),
            'url' => $url
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic M2EwMDZhZGYtZDdhYy00NTExLWJjZjEtOWYyMDVmZWY4MzQ1'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
    }
}
add_action('wp_insert_post', 'send_bbpress_push_notification');
//END fakhar Notifications

//fakhar Submission form for the city by users
// Location Submission Form with Pending City Status



function custom_get_countries_by_continent() {
    if (!isset($_GET['continent'])) {
        wp_send_json([]);
    }

    $continent = sanitize_text_field($_GET['continent']);
    $continent_term = get_term_by('slug', $continent, 'location');

    if (!$continent_term) {
        wp_send_json([]);
    }

    // Get all child terms (countries) of the selected continent
    $countries = get_terms([
        'taxonomy' => 'location',
        'hide_empty' => false,
        'parent' => $continent_term->term_id,
    ]);

    $response = [];
    foreach ($countries as $country) {
        $response[] = [
            'name' => $country->name,
            'slug' => $country->slug,
        ];
    }

    wp_send_json($response);
}
add_action('wp_ajax_custom_get_countries_by_continent', 'custom_get_countries_by_continent');
add_action('wp_ajax_nopriv_custom_get_countries_by_continent', 'custom_get_countries_by_continent');

//city submission


// end city submission
//list coutries in side bar
function custom_list_countries_shortcode() {
    $parent_terms = get_terms([
        'taxonomy'   => 'location',
        'parent'     => 0, // Get top-level terms (Continents)
        'hide_empty' => false,
    ]);

    $country_terms = [];

    if (!empty($parent_terms) && !is_wp_error($parent_terms)) {
        foreach ($parent_terms as $parent) {
            $sub_terms = get_terms([
                'taxonomy'   => 'location',
                'parent'     => $parent->term_id, // Get second-level terms (Countries)
                'hide_empty' => false,
            ]);

            if (!empty($sub_terms) && !is_wp_error($sub_terms)) {
                $country_terms = array_merge($country_terms, $sub_terms);
            }
        }
    }

    if (!empty($country_terms)) {
        $output = '<ul class="country-list">';

        foreach ($country_terms as $country) {
            $country_link = get_term_link($country);
            $output .= '<li><a href="' . esc_url($country_link) . '">' . esc_html($country->name) . '</a></li>';
        }

        $output .= '</ul>';
    } else {
        $output = '<p>No countries found.</p>';
    }

    return $output;
}
add_shortcode('list_countries', 'custom_list_countries_shortcode');
//end list coutries in side bar
//list continents in homepge
function list_continents_shortcode() {
    // Get all continents (top-level locations)
    $continents = get_terms([
        'taxonomy'   => 'location',
        'parent'     => 0, // Only top-level terms (continents)
        'hide_empty' => false, // Show all, even if empty
        'meta_query' => [
            [
                'key'     => 'pending_approval',
                'compare' => 'NOT EXISTS', // Exclude pending locations
            ],
        ],
    ]);

    if (empty($continents) || is_wp_error($continents)) {
        return '<p>' . esc_html__('No continents found.', 'disputo') . '</p>';
    }

    ob_start(); // Start output buffering
    ?>

    <ul id="forums-list-continents" class="bbp-forums">
        <li class="bbp-header">
            <ul class="forum-titles">
                <li class="bbp-forum-info"><?php esc_html_e('Continent', 'disputo'); ?></li>
                <li class="bbp-forum-topic-count"><i class="fa fa-globe" data-toggle="tooltip" title="<?php esc_attr_e('Countries Count', 'disputo'); ?>"></i></li>
                <li class="bbp-forum-topic-count"><i class="fa fa-comments" data-toggle="tooltip" title="<?php esc_attr_e('Forums Count', 'disputo'); ?>"></i></li>
            </ul>
        </li>

        <li class="bbp-body">
            <?php foreach ($continents as $continent) : 
                // Get all child terms (countries)
                $countries = get_terms([
                    'taxonomy'   => 'location',
                    'parent'     => $continent->term_id,
                    'hide_empty' => false,
                ]);
                $country_count = !empty($countries) && !is_wp_error($countries) ? count($countries) : 0;

                // Get count of forums linked to this continent
                $forums_count = new WP_Query([
                    'post_type'      => 'forum', // bbPress forum post type
                    'posts_per_page' => -1,
                    'tax_query'      => [
                        [
                            'taxonomy' => 'location',
                            'field'    => 'term_id',
                            'terms'    => $continent->term_id,
                        ],
                    ],
                ]);
                $forums_count = $forums_count->found_posts;
            ?>
                <ul id="bbp-forum-<?php echo esc_attr($continent->term_id); ?>" class="bbp-forum">
                    <li class="bbp-forum-info">
                        <a href="<?php echo esc_url(get_term_link($continent)); ?>">
                            <?php echo esc_html($continent->name); ?>
                        </a>
                    </li>
                    <li class="bbp-forum-topic-count">
                        <?php echo intval($country_count); ?>
                    </li>
                    <li class="bbp-forum-topic-count">
                        <?php echo intval($forums_count); ?>
                    </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>

    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('list_continents', 'list_continents_shortcode');

// end lists continent in homepage
// cities in category
function list_all_cities_shortcode() {
    global $wpdb;

    // Get all terms (grandchild items only)
    $cities = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => false,
        'orderby'    => 'term_id', // Sort by recent
        'order'      => 'DESC',    // Newest first
        'meta_query' => [
            [
                'key'     => 'pending_approval',
                'compare' => 'NOT EXISTS', // Exclude pending locations
            ],
        ],
    ]);

    // Filter to only include grandchild items
    $filtered_cities = [];
    foreach ($cities as $city) {
        $parent_term = get_term($city->parent, 'location');
        if ($parent_term && $parent_term->parent != 0) {
            $filtered_cities[] = $city; // Ensure only grandchild terms
        }
    }

    if (empty($filtered_cities)) {
        return '<p>' . esc_html__('No cities found.', 'disputo') . '</p>';
    }

    ob_start(); // Start output buffering
    ?>

    <ul id="forums-list-cities" class="bbp-forums">
        <li class="bbp-header">
            <ul class="forum-titles">
                <li class="bbp-forum-info"><?php esc_html_e('City', 'disputo'); ?></li>
                <li class="bbp-forum-topic-count"><i class="fa fa-comments" data-toggle="tooltip" title="<?php esc_attr_e('Forums Count', 'disputo'); ?>"></i></li>
            </ul>
        </li>

        <li class="bbp-body">
            <?php foreach ($filtered_cities as $city) : 
                // Get count of forums linked to this city
                $forums_count = new WP_Query([
                    'post_type'      => 'forum', // bbPress forum post type
                    'posts_per_page' => -1,
                    'tax_query'      => [
                        [
                            'taxonomy' => 'location',
                            'field'    => 'term_id',
                            'terms'    => $city->term_id,
                        ],
                    ],
                ]);
                $forums_count = $forums_count->found_posts;
            ?>
                <ul id="bbp-forum-<?php echo esc_attr($city->term_id); ?>" class="bbp-forum">
                    <li class="bbp-forum-info">
                        <a href="<?php echo esc_url(get_term_link($city)); ?>">
                            <?php echo esc_html($city->name); ?>
                        </a>
                    </li>
                    <li class="bbp-forum-topic-count">
                        <?php echo intval($forums_count); ?>
                    </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>

    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('list_all_cities', 'list_all_cities_shortcode');



function list_only_cities_shortcode() {
    // Get all terms in the 'location' taxonomy
    $all_terms = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => false, // Show all, even if empty
        'meta_query' => [
            [
                'key'     => 'pending_approval',
                'compare' => 'NOT EXISTS', // Exclude pending locations
            ],
        ],
    ]);

    if (empty($all_terms) || is_wp_error($all_terms)) {
        return '<p>' . esc_html__('No cities found.', 'disputo') . '</p>';
    }

    $cities = [];

    // Filter only grandchild terms (cities) and check for forum count
    foreach ($all_terms as $term) {
        $parent = get_term($term->parent, 'location'); // Get the parent term
        if ($parent && $parent->parent != 0) { // Ensure it's a grandchild (has a parent AND a grandparent)

            // Get count of forums linked to this city
            $forums_query = new WP_Query([
                'post_type'      => 'forum', // bbPress forum post type
                'posts_per_page' => -1,
                'tax_query'      => [
                    [
                        'taxonomy' => 'location',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ],
                ],
            ]);
            $forums_count = $forums_query->found_posts;

            // Only add cities that have at least one forum
            if ($forums_count > 0) {
                $cities[] = [
                    'term'        => $term,
                    'forums_count' => $forums_count,
                ];
            }
        }
    }

    // Limit to only 5 cities
    $cities = array_slice($cities, 0, 5);

    if (empty($cities)) {
        return '<p>' . esc_html__('No cities found.', 'disputo') . '</p>';
    }

    ob_start(); // Start output buffering
    ?>

    <ul id="forums-list-cities" class="bbp-forums">
        <li class="bbp-header">
            <ul class="forum-titles">
                <li class="bbp-forum-info"><?php esc_html_e('City', 'disputo'); ?></li>
                <li class="bbp-forum-topic-count"><i class="fa fa-list" data-toggle="tooltip" title="<?php esc_attr_e('Forums Count', 'disputo'); ?>"></i></li>
            </ul>
        </li>

        <li class="bbp-body">
            <?php foreach ($cities as $city) : ?>
                <ul id="bbp-forum-<?php echo esc_attr($city['term']->term_id); ?>" class="bbp-forum">
                    <li class="bbp-forum-info">
                        <a href="<?php echo esc_url(get_term_link($city['term'])); ?>">
                            <?php echo esc_html($city['term']->name); ?>
                        </a>
                    </li>
                    <li class="bbp-forum-topic-count">
                        <?php echo intval($city['forums_count']); ?>
                    </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>

    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('list_only_cities', 'list_only_cities_shortcode');

// end 5 cities showing


// End cities in category

// start cities in category
// function bbpress_forum_categories_shortcode() {
//     $categories = get_posts(array(
//         'post_type'      => 'forum', // bbPress forums are stored as a custom post type
//         'posts_per_page' => -1, // Get all categories
//         'orderby'        => 'title',
//         'order'          => 'ASC',
//         'meta_query'     => array(
//             array(
//                 'key'   => '_bbp_forum_type', // Check forum type
//                 'value' => 'category', // Only fetch categories
//             ),
//         ),
//     ));

//     if (empty($categories)) {
//         return '<p>No forum categories found.</p>';
//     }

//     $output = '<ul>';
//     foreach ($categories as $category) {
//         $category_url = get_permalink($category->ID) . '?selected_category=' . $category->post_name; 
//         $output .= '<li><a href="' . esc_url($category_url) . '">' . esc_html($category->post_title) . '</a></li>';
//     }
//     $output .= '</ul>';

//     return $output;
// }
// add_shortcode('bbpress_categories', 'bbpress_forum_categories_shortcode');
function bbpress_forum_categories_shortcode() {
    $categories = get_posts(array(
        'post_type'      => 'forum', // bbPress forums are stored as a custom post type
        'posts_per_page' => -1, // Get all categories
        'orderby'        => 'title',
        'order'          => 'ASC',
        'meta_query'     => array(
            array(
                'key'   => '_bbp_forum_type', // Check forum type
                'value' => 'category', // Only fetch categories
            ),
        ),
    ));

    if (empty($categories)) {
        return '<p>No forum categories found.</p>';
    }

    ob_start(); ?>

    <ul id="forums-list" class="bbp-forums">
        <li class="bbp-header">
            <ul class="forum-titles">
                <li class="bbp-forum-info"><?php esc_html_e('Forum', 'disputo'); ?></li>
                <li class="bbp-forum-freshness"><i class="fa fa-clock-o" data-toggle="tooltip" title="<?php esc_attr_e('Freshness', 'disputo'); ?>"></i></li>
            </ul>
        </li>
        <li class="bbp-body">
            <?php foreach ($categories as $category) : 
                $category_url = get_permalink($category->ID) . '?selected_category=' . $category->post_name; ?>
                <ul id="bbp-forum-<?php echo esc_attr($category->ID); ?>" class="bbp-forum">
                    <li class="bbp-forum-info">
                        <div class="disputo-forum-table-wrapper">
                            <?php if (has_post_thumbnail($category->ID)) : 
                                $forum_img = get_the_post_thumbnail_url($category->ID, 'thumbnail'); ?>
                                <div class="disputo-forum-left">
                                    <a href="<?php echo esc_url($category_url); ?>">
                                        <img src="<?php echo esc_url($forum_img); ?>" alt="<?php echo esc_attr($category->post_title); ?>" />
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="disputo-forum-right">
                                <a class="bbp-forum-title" href="<?php echo esc_url($category_url); ?>">
                                    <?php echo esc_html($category->post_title); ?>
                                </a>
                                <div class="bbp-forum-content"><?php echo esc_html($category->post_content); ?></div>
                            </div>
                        </div>
                    </li>

                    <li class="bbp-forum-freshness">
                        <div class="disputo-freshness-box">
                            <div class="disputo-freshness-left">
                                <div class="disputo-freshness-name">
                                    <?php 
                                    $last_active_id = bbp_get_forum_last_active_id($category->ID);
                                    if ($last_active_id) {
                                        echo get_the_author_meta('display_name', get_post_field('post_author', $last_active_id));
                                    } else {
                                        echo esc_html__('No recent activity', 'disputo');
                                    }
                                    ?>
                                </div>
                                <div class="disputo-freshness-link">
                                    <?php if ($last_active_id) : ?>
                                        <a href="<?php echo esc_url(get_permalink($last_active_id)); ?>">
                                            <?php echo esc_html(human_time_diff(get_post_time('U', true, $last_active_id), current_time('timestamp')) . ' ago'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="disputo-freshness-right">
                                <?php echo get_avatar(get_post_field('post_author', $last_active_id), 45); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>

    <?php return ob_get_clean();
}

add_shortcode('bbpress_categories', 'bbpress_forum_categories_shortcode');





function custom_bbpress_template($template) {
    if (bbp_is_single_forum()) {
        $forum_id = bbp_get_forum_id();
        
        // Check if the current forum is a category
        if (bbp_get_forum_type($forum_id) === 'category') {
            $custom_template = locate_template('bbpress-category.php');

            if (!empty($custom_template)) {
                return $custom_template; // Load the custom template
            }
        }
    }
    
    return $template; // Default bbPress template
}
add_filter('template_include', 'custom_bbpress_template');

// end city in category

//list cities in category shortcode
function list_cities_for_forums_shortcode() {
    $all_terms = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => false,
        'meta_query' => [
            [
                'key'     => 'pending_approval',
                'compare' => 'NOT EXISTS',
            ],
        ],
    ]);

    if (empty($all_terms) || is_wp_error($all_terms)) {
        return '<p>' . esc_html__('No cities found.', 'disputo') . '</p>';
    }

    $cities = [];

    // ✅ Filter only grandchild terms (cities)
    foreach ($all_terms as $term) {
        $parent = get_term($term->parent, 'location');
        if ($parent && $parent->parent != 0) { // Only cities (grandchildren)
            $cities[] = $term;
        }
    }

    if (empty($cities)) {
        return '<p>' . esc_html__('No cities found.', 'disputo') . '</p>';
    }

    ob_start(); // Start output buffering
    ?>

    <ul id="forums-list-cities" class="bbp-forums">
        <li class="bbp-header">
            <ul class="forum-titles">
                <li class="bbp-forum-info"><?php esc_html_e('City', 'disputo'); ?></li>
                <li class="bbp-forum-topic-count"><i class="fa fa-list" data-toggle="tooltip" title="<?php esc_attr_e('Forums Count', 'disputo'); ?>"></i></li>
            </ul>
        </li>

        <li class="bbp-body">
            <?php 
            // ✅ Fetch selected category from URL
            $category_slug = isset($_GET['selected_category']) ? sanitize_title($_GET['selected_category']) : 'general-discussion';

            foreach ($cities as $city) :
                $country_term = get_term($city->parent, 'location');
                $continent_term = ($country_term && $country_term->parent) ? get_term($country_term->parent, 'location') : null;

                $continent_slug = $continent_term ? sanitize_title($continent_term->slug) : 'unknown-continent';
                $country_slug = $country_term ? sanitize_title($country_term->slug) : 'unknown-country';
                $city_slug = sanitize_title($city->slug);

                // ✅ Generate correct dynamic city URL
                $city_url = home_url("/location/{$continent_slug}/{$country_slug}/{$city_slug}/{$category_slug}-in-{$city_slug}/");

                // Get count of forums linked to this city
                $forums_query = new WP_Query([
                    'post_type'      => 'forum',
                    'posts_per_page' => -1,
                    'tax_query'      => [
                        [
                            'taxonomy' => 'location',
                            'field'    => 'term_id',
                            'terms'    => $city->term_id,
                        ],
                    ],
                ]);
                $forums_count = $forums_query->found_posts;
            ?>
                <ul id="bbp-forum-<?php echo esc_attr($city->term_id); ?>" class="bbp-forum">
                    <li class="bbp-forum-info">
                        <a href="<?php echo esc_url($city_url); ?>">
                            <?php echo esc_html($city->name); ?>
                        </a>
                    </li>
                    <li class="bbp-forum-topic-count">
                        <?php echo intval($forums_count); ?>
                    </li>
                </ul>
            <?php endforeach; ?>
        </li>
    </ul>

    <?php
    return ob_get_clean(); // Return the buffered content
}
add_shortcode('list_cities_for_forums', 'list_cities_for_forums_shortcode');


// end list cities in category shortcode
?>