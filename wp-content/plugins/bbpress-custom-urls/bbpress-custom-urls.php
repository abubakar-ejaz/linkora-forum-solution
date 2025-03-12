<?php
/*
Plugin Name: bbPress Custom Location URLs
Description: Custom URL structure for bbPress forums in the format /(Continent)/(Country)/(City)/(Forum Slug) or /(Continent)/(Country).
Version: 1.2
Author: Fakhar
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Register a custom taxonomy for location hierarchy
function register_bbpress_location_taxonomy() {
    register_taxonomy('location', 'forum', [
        'label'             => __('Location', 'textdomain'),
        'rewrite'           => ['slug' => 'location'],
        'hierarchical'      => true, // Enables continent > country > city hierarchy
        'show_admin_column' => true,
    ]);
}
add_action('init', 'register_bbpress_location_taxonomy');

// Add custom rewrite rules
function bbpress_custom_urls_rewrite_rules() {
    // Custom Continent → Country → City → Forum Slug structure
    add_rewrite_rule('^location/([^/]+)/([^/]+)/([^/]+)/([^/]+)/?$',
        'index.php?post_type=forum&location_1=$matches[1]&location_2=$matches[2]&location_3=$matches[3]&name=$matches[4]',
        'top'
    );

    // Custom Continent → Country → City archive page
    add_rewrite_rule('^location/([^/]+)/([^/]+)/([^/]+)/?$',
        'index.php?taxonomy=location&term=$matches[3]',
        'top'
    );

    // Custom Continent → Country structure (Fix for your issue)
    add_rewrite_rule('^location/([^/]+)/([^/]+)/?$',
        'index.php?taxonomy=location&term=$matches[2]',
        'top'
    );
}
add_action('init', 'bbpress_custom_urls_rewrite_rules');

// Register custom query vars for locations
function bbpress_custom_urls_query_vars($vars) {
    $vars[] = 'location_1';
    $vars[] = 'location_2';
    $vars[] = 'location_3';
    return $vars;
}
add_filter('query_vars', 'bbpress_custom_urls_query_vars');

// Modify the main query for custom location URLs
function bbpress_custom_urls_pre_get_posts($query) {
    if (!$query->is_main_query() || is_admin()) {
        return;
    }

    $location_1 = $query->get('location_1');
    $location_2 = $query->get('location_2');
    $location_3 = $query->get('location_3');

    if ($location_1 && $location_2 && $location_3) {
        $query->set('tax_query', [
            [
                'taxonomy' => 'location',
                'field'    => 'slug',
                'terms'    => [$location_1, $location_2, $location_3],
                'operator' => 'AND',
            ],
        ]);
    }

    // Handle Continent → Country (fix for the missing URL structure)
    if ($location_1 && $location_2 && !$location_3) {
        $query->set('tax_query', [
            [
                'taxonomy' => 'location',
                'field'    => 'slug',
                'terms'    => [$location_2],
            ],
        ]);
    }
}
add_action('pre_get_posts', 'bbpress_custom_urls_pre_get_posts');

// Modify forum links to match the custom URL structure
function bbpress_custom_urls_forum_link($url, $forum_id) {
    $terms = wp_get_post_terms($forum_id, 'location', ['orderby' => 'parent', 'order' => 'ASC']);

    if (!empty($terms)) {
        // Ensure the terms are properly structured as Continent > Country > City
        $locations = [];

        foreach ($terms as $term) {
            if ($term->parent == 0) {
                $locations[0] = $term->slug; // Continent
            } else {
                $parent_term = get_term($term->parent, 'location');

                if ($parent_term->parent == 0) {
                    $locations[1] = $term->slug; // Country
                } else {
                    $locations[2] = $term->slug; // City
                }
            }
        }

        ksort($locations); // Sort by hierarchy level (continent > country > city)

        // Construct the correct URL format
        $location_path = implode('/', array_filter($locations));
        $url = home_url('/location/' . $location_path . '/' . get_post_field('post_name', $forum_id) . '/');
    }

    return $url;
}
add_filter('bbp_get_forum_permalink', 'bbpress_custom_urls_forum_link', 10, 2);

// Flush rewrite rules on activation
function bbpress_custom_urls_activate() {
    register_bbpress_location_taxonomy();
    bbpress_custom_urls_rewrite_rules();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'bbpress_custom_urls_activate');

// Flush rewrite rules on deactivation
function bbpress_custom_urls_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'bbpress_custom_urls_deactivate');

// City Submission Form
function location_submission_form() {
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to submit a city.</p>';
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_city'])) {
        $continent = sanitize_text_field($_POST['continent']);
        $country = sanitize_text_field($_POST['country']);
        $city = sanitize_text_field($_POST['city']);

        // Validate input
        if (empty($continent) || empty($country) || empty($city)) {
            return '<p style="color:red;">Please fill in all fields.</p>';
        }

        // Check if the city already exists
        $existing_city = term_exists($city, 'location');
        if ($existing_city) {
            return '<p style="color:red;">This city already exists.</p>';
        }

        // Get country term ID
        $country_term = get_term_by('slug', $country, 'location');
        if (!$country_term) {
            return '<p style="color:red;">Invalid country selection.</p>';
        }

        // Add the new city as a child of the selected country
        $new_city = wp_insert_term($city, 'location', [
            'parent' => $country_term->term_id,
        ]);

        if (!is_wp_error($new_city) && isset($new_city['term_id'])) {
            add_term_meta($new_city['term_id'], 'pending_approval', 1, true);
            return '<p style="color:green;">City submitted successfully and awaiting admin approval.</p>';
        } else {
            return '<p style="color:red;">Error submitting city. Please try again.</p>';
        }
    }

    // Get all continents (top-level terms)
    $continents = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => false,
        'parent'     => 0, // Only top-level terms
    ]);

    ob_start();
    ?>
    <form method="POST">
        <label for="continent">Select Continent:</label>
        <select name="continent" id="continent" required>
            <option value="">-- Select Continent --</option>
            <?php foreach ($continents as $continent) : ?>
                <option value="<?php echo esc_attr($continent->slug); ?>">
                    <?php echo esc_html($continent->name); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="country">Select Country:</label>
        <select name="country" id="country" required>
            <option value="">-- Select Country --</option>
        </select>

        <label for="city">Enter New City:</label>
        <input type="text" name="city" required placeholder="Enter city name">

        <button type="submit" name="submit_city">Submit</button>
    </form>

    <script>
        document.getElementById("continent").addEventListener("change", function() {
            let continentSlug = this.value;
            let countryDropdown = document.getElementById("country");

            countryDropdown.innerHTML = '<option value="">Loading...</option>';

            fetch('<?php echo admin_url("admin-ajax.php?action=custom_get_countries_by_continent"); ?>' + '&continent=' + continentSlug)
                .then(response => response.json())
                .then(data => {
                    countryDropdown.innerHTML = '<option value="">-- Select Country --</option>';
                    data.forEach(country => {
                        countryDropdown.innerHTML += '<option value="' + country.slug + '">' + country.name + '</option>';
                    });
                });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('location_submission', 'location_submission_form');

// Hide Pending Cities from Frontend
function hide_pending_cities_from_frontend($terms, $taxonomy, $args) {
    if ($taxonomy === 'location' && !is_admin()) {
        foreach ($terms as $key => $term) {
            $pending = get_term_meta($term->term_id, 'pending_approval', true);
            if ($pending) {
                unset($terms[$key]);
            }
        }
    }
    return $terms;
}
add_filter('get_terms', 'hide_pending_cities_from_frontend', 10, 3);

// Add "Approval Status" Column in Admin Panel
function add_pending_status_column($columns) {
    $columns['status'] = 'Approval Status';
    return $columns;
}
add_filter('manage_edit-location_columns', 'add_pending_status_column');

function display_pending_status_column($content, $column_name, $term_id) {
    if ($column_name === 'status') {
        $pending = get_term_meta($term_id, 'pending_approval', true);
        
        if ($pending) {
            return '<span style="color: red;">Pending</span> | 
                <a href="' . admin_url("edit-tags.php?taxonomy=location&approve_city=$term_id") . '" class="button">Approve</a>';
        } else {
            return '<span style="color: green;">Approved</span>';
        }
    }
    return $content;
}
add_filter('manage_location_custom_column', 'display_pending_status_column', 10, 3);

// Handle City Approval (Admin Panel)
function handle_city_approval() {
    if (isset($_GET['approve_city']) && current_user_can('manage_options')) {
        $term_id = intval($_GET['approve_city']);
        delete_term_meta($term_id, 'pending_approval'); // Remove pending status
        wp_redirect(admin_url("edit-tags.php?taxonomy=location"));
        exit;
    }
}
add_action('admin_init', 'handle_city_approval');

// Ensure Pending Cities Are Not Accessible on the Frontend
function block_pending_city_access() {
    if (is_tax('location')) {
        $term = get_queried_object();
        if ($term && get_term_meta($term->term_id, 'pending_approval', true)) {
            wp_redirect(home_url()); // Redirect to homepage or a custom page
            exit;
        }
    }
}
add_action('template_redirect', 'block_pending_city_access');

// Exclude Pending Cities from All Frontend Queries
function exclude_pending_cities_from_all_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        $tax_query = $query->get('tax_query', []);
        $tax_query[] = [
            'taxonomy' => 'location',
            'field'    => 'term_id',
            'terms'    => get_terms([
                'taxonomy'   => 'location',
                'hide_empty' => false,
                'meta_key'   => 'pending_approval',
                'meta_value' => '1',
                'fields'     => 'ids',
            ]),
            'operator' => 'NOT IN',
        ];
        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'exclude_pending_cities_from_all_queries');