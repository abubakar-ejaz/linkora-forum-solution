<?php
/*
Plugin Name: bbPress Custom Search Filter
Description: Adds a hierarchical search filter (Continent → Country → City → Categories) for bbPress forums.
Version: 1.5
Author: Fakhar
*/

if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to display the search form
function bbp_custom_search_form_shortcode() {
    ob_start();
    ?>
    <form role="search" method="get" id="bbp-header-search-form">
    <div class="input-group">
        <input type="hidden" name="action" value="bbp-search-request" />

        <!-- Continent Dropdown -->
        <select name="continent" id="continent" class="bbp_search form-control">
            <option value=""><?php esc_attr_e('Select Continent', 'disputo'); ?></option>
            <?php
            $continents = get_terms([
                'taxonomy' => 'location',
                'hide_empty' => false,
                'parent' => 0,
            ]);
            foreach ($continents as $continent) {
                echo '<option value="' . esc_attr($continent->slug) . '">' . esc_html($continent->name) . '</option>';
            }
            ?>
        </select>

        <!-- Country Dropdown -->
        <select name="country" id="country" class="bbp_search form-control" disabled>
            <option value=""><?php esc_attr_e('Select Country', 'disputo'); ?></option>
        </select>

        <!-- City Dropdown -->
        <select name="city" id="city" class="bbp_search form-control" disabled>
            <option value=""><?php esc_attr_e('Select City', 'disputo'); ?></option>
        </select>

        <!-- Category Dropdown -->
        <select name="category" id="category" class="bbp_search form-control" disabled>
            <option value=""><?php esc_attr_e('Select Category', 'disputo'); ?></option>
        </select>

        <div class="input-group-append">
            <button type="submit" id="bbp-search-btn" class="btn btn-info"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

    <?php
    return ob_get_clean();
}
add_shortcode('bbp_custom_search_form', 'bbp_custom_search_form_shortcode');

// Enqueue JavaScript
function bbp_custom_search_enqueue_scripts() {
    wp_enqueue_script('bbp-custom-search', plugin_dir_url(__FILE__) . 'bbp-custom-search.js', ['jquery'], null, true);
    wp_localize_script('bbp-custom-search', 'bbp_custom_search', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'bbp_custom_search_enqueue_scripts');

// Fetch Countries by Continent (AJAX)
function get_countries_by_continent() {
    if (isset($_POST['continent_slug'])) {
        $continent_slug = sanitize_text_field($_POST['continent_slug']);
        $continent_term = get_term_by('slug', $continent_slug, 'location');

        if ($continent_term) {
            $countries = get_terms([
                'taxonomy' => 'location',
                'hide_empty' => false,
                'parent' => $continent_term->term_id,
                'meta_query' => [
                    [
                        'key' => 'pending_approval',
                        'compare' => 'NOT EXISTS', // Exclude pending cities
                    ],
                ],
            ]);

            echo '<option value="">' . esc_attr__('Select Country', 'disputo') . '</option>';
            foreach ($countries as $country) {
                echo '<option value="' . esc_attr($country->slug) . '">' . esc_html($country->name) . '</option>';
            }
        }
    }
    wp_die();
}
add_action('wp_ajax_get_countries_by_continent', 'get_countries_by_continent');
add_action('wp_ajax_nopriv_get_countries_by_continent', 'get_countries_by_continent');

// Fetch Cities by Country (AJAX)
function get_cities_by_country() {
    if (isset($_POST['country_slug'])) {
        $country_slug = sanitize_text_field($_POST['country_slug']);
        $country_term = get_term_by('slug', $country_slug, 'location');

        if ($country_term) {
            $cities = get_terms([
                'taxonomy' => 'location',
                'hide_empty' => false,
                'parent' => $country_term->term_id,
                'meta_query' => [
                    [
                        'key' => 'pending_approval',
                        'compare' => 'NOT EXISTS', // Exclude pending cities
                    ],
                ],
            ]);

            echo '<option value="">' . esc_attr__('Select City', 'disputo') . '</option>';
            foreach ($cities as $city) {
                echo '<option value="' . esc_attr($city->slug) . '">' . esc_html($city->name) . '</option>';
            }
        }
    }
    wp_die();
}
add_action('wp_ajax_get_cities_by_country', 'get_cities_by_country');
add_action('wp_ajax_nopriv_get_cities_by_country', 'get_cities_by_country');

// Fetch Categories by City (AJAX)
function get_categories_by_city() {
    if (isset($_POST['city_slug'])) {
        $city_slug = sanitize_text_field($_POST['city_slug']);
        $categories = get_posts([
            'post_type' => 'forum',
            'posts_per_page' => -1,
            'tax_query' => [
                [
                    'taxonomy' => 'location',
                    'field' => 'slug',
                    'terms' => $city_slug,
                ],
            ],
        ]);

        echo '<option value="">' . esc_attr__('Select Category', 'disputo') . '</option>';
        foreach ($categories as $category) {
            echo '<option value="' . esc_attr($category->post_name) . '">' . esc_html($category->post_title) . '</option>';
        }
    }
    wp_die();
}
add_action('wp_ajax_get_categories_by_city', 'get_categories_by_city');
add_action('wp_ajax_nopriv_get_categories_by_city', 'get_categories_by_city');

// Handle Form Submission to Build the Correct URL
function bbp_custom_search_form_submit() {
    if (isset($_POST['continent']) && isset($_POST['country']) && isset($_POST['city']) && isset($_POST['category'])) {
        $continent = sanitize_text_field($_POST['continent']);
        $country = sanitize_text_field($_POST['country']);
        $city = sanitize_text_field($_POST['city']);
        $category = sanitize_text_field($_POST['category']);

        // Build the URL
        $url = "/location/";

        if ($continent) {
            $url .= $continent . "/";
        }
        if ($country) {
            $url .= $country . "/";
        }
        if ($city) {
            $url .= $city . "/";
        }
        if ($category) {
            $url .= $category . "/"; // Use the slug for the category, not ID
        }

        // Redirect
        wp_redirect(home_url($url));
        exit();
    }
}
add_action('wp_ajax_bbp_custom_search_submit', 'bbp_custom_search_form_submit');
add_action('wp_ajax_nopriv_bbp_custom_search_submit', 'bbp_custom_search_form_submit');