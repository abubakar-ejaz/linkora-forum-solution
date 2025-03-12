<?php
get_header();

$term = get_queried_object();
// Function to generate breadcrumbs for location terms
function get_location_breadcrumbs($term) {
    $breadcrumbs = [];
    $current_term = $term;

    // Traverse up the hierarchy to build the breadcrumb trail
    while ($current_term) {
        $breadcrumbs[] = '<a href="' . get_term_link($current_term) . '">' . $current_term->name . '</a>';
        if ($current_term->parent) {
            $current_term = get_term($current_term->parent, 'location');
        } else {
            $current_term = false; // Stop if no parent exists
        }
    }

    // Reverse the array to display from top-level to current term
    $breadcrumbs = array_reverse($breadcrumbs);

    // Add "Home" link at the beginning
    array_unshift($breadcrumbs, '<a href="' . home_url('/') . '">Home</a>');

    // Join breadcrumbs with a separator
    return implode(' &raquo; ', $breadcrumbs);
}

// Generate breadcrumbs for the current term
$breadcrumbs = get_location_breadcrumbs($term);

// Check if the term exists and has children
if ($term && !is_wp_error($term)) {
    $children = get_terms([
        'taxonomy' => 'location',
        'parent'   => $term->term_id,
        'hide_empty' => false, // Show even if empty
        'meta_query' => [
            [
                'key' => 'pending_approval',
                'compare' => 'NOT EXISTS', // Exclude pending cities
            ],
        ],
    ]);
}


?>
<div id="header-wrapper">
    <header>
        <?php get_template_part('templates/header', 'template'); ?>
    </header>
    <div class="disputo-page-title <?php echo $disputo_no_boxed ? 'noboxed-title' : ''; ?>">
        <div class="container">
            <div id="disputo-header-search">
				<!-- Display Breadcrumbs -->
                <div class="disputo-breadcrumbs">
                    <?php echo $breadcrumbs; ?>
                </div>
                <h1><?php echo esc_html($term->name); ?></h1>
                <?php get_template_part('templates/bbpresslg', 'template'); ?>
            </div>
        </div>
    </div>
</div>     
<main class="disputo-main-container">
    <div class="container">
        <div id="disputo-main-inner" class="<?php echo $disputo_no_boxed ? 'nomargin noboxed' : ''; ?>">   

            <?php if (!empty($children)) : ?>
                <h2><?php esc_html_e('Sub-locations', 'disputo'); ?></h2>
                <ul class="bbp-forums">
					<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">

	<li class="bbp-header">

		<ul class="forum-titles">
			<li class="bbp-forum-info"><?php esc_html_e( 'Forum', 'disputo' ); ?></li>
			<li class="bbp-forum-topic-count"><i class="fa fa-comment" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'TOPICS', 'disputo' ); ?>"></i></li>
			<li class="bbp-forum-reply-count"><i class="fa fa-comments" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'REPLIES', 'disputo' ); ?>"></i></li>
			<li class="bbp-forum-freshness"><i class="fa fa-clock-o" data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'FRESHNESS', 'disputo' ); ?>"></i></li>
		</ul>

	</li>

	<li class="bbp-body">
                    <?php foreach ($children as $child) : ?>
					<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
                        <li class="bbp-forum-info">
                            <a href="<?php echo esc_url(get_term_link($child)); ?>">
                                <?php echo esc_html($child->name); ?>
                            </a>
                        </li>
					<li class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></li>

	<li class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></li>
    
    <li class="bbp-forum-freshness">     
        <div class="disputo-freshness-box">
            <div class="disputo-freshness-left">
                <div class="disputo-freshness-name">
                <?php do_action( 'bbp_theme_before_topic_author' ); ?>
                <?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ); ?>
                <?php do_action( 'bbp_theme_after_topic_author' ); ?>
                </div>
                <div class="disputo-freshness-link">
                <?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
                <?php bbp_forum_freshness_link(); ?>
                <?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
                </div>
            </div>
            <?php
            $disputo_verified_user = disputo_verified_check(bbp_get_topic_author_id(bbp_get_forum_last_active_id())); 
            $disputo_verified_class = '';
            if ($disputo_verified_user == 'verified') {
                $disputo_verified_class = 'disputo-verified-user';
            }
            ?>
            <div class="disputo-freshness-right <?php echo esc_attr($disputo_verified_class); ?>">
                <?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 45, 'type' => 'avatar' ) ); ?>
            </div>
        </div>
	</li>
						</ul>
                    <?php endforeach; ?>
						</li>
                </ul>
            <?php endif; ?>
        </ul>

            <?php
            // Check if the current term is a city (has no children)
            if (empty($children)) {
                // Fetch related forums only for city-level terms
                $forums = new WP_Query([
                    'post_type' => 'forum',
                    'tax_query' => [[
                        'taxonomy' => 'location',
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ]],
                ]);

                if ($forums->have_posts()) :
            ?>

                <h2><?php esc_html_e('Forums in ' . $term->name, 'disputo'); ?></h2>
			
                <ul id="forums-list-<?php echo esc_attr($term->term_id); ?>" class="bbp-forums">
                    <li class="bbp-header">
                        <ul class="forum-titles">
                            <li class="bbp-forum-info"><?php esc_html_e('Forum', 'disputo'); ?></li>
                            <li class="bbp-forum-topic-count"><i class="fa fa-comment" data-toggle="tooltip" title="<?php esc_attr_e('TOPICS', 'disputo'); ?>"></i></li>
                            <li class="bbp-forum-reply-count"><i class="fa fa-comments" data-toggle="tooltip" title="<?php esc_attr_e('REPLIES', 'disputo'); ?>"></i></li>
                            <li class="bbp-forum-freshness"><i class="fa fa-clock-o" data-toggle="tooltip" title="<?php esc_attr_e('FRESHNESS', 'disputo'); ?>"></i></li>
                        </ul>
                    </li>

                    <li class="bbp-body">
                        <?php while ($forums->have_posts()) : $forums->the_post(); ?>
                            <ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<li class="bbp-forum-info">

		<?php if ( bbp_is_user_home() && bbp_is_subscriptions() ) : ?>

			<span class="bbp-row-actions">

				<?php do_action( 'bbp_theme_before_forum_subscription_action' ); ?>

				<?php bbp_forum_subscription_link( array( 'before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;' ) ); ?>

				<?php do_action( 'bbp_theme_after_forum_subscription_action' ); ?>

			</span>

		<?php endif; ?>
        
        <div class="disputo-forum-table-wrapper">
        <?php 
        if (has_post_thumbnail(bbp_get_forum_id())) {
            $disputo_forum_img_id = get_post_thumbnail_id(bbp_get_forum_id());
            $disputo_forum_img_array = wp_get_attachment_image_src($disputo_forum_img_id, 'thumbnail', true);
            $disputo_forum_img = $disputo_forum_img_array[0];
        ?>      
        <div class="disputo-forum-left">
            <a href="<?php bbp_forum_permalink(); ?>">
                <img src="<?php echo esc_url($disputo_forum_img); ?>" alt="<?php bbp_forum_title(); ?>" />
            </a>
        </div>
        <?php } ?>    
        <div class="disputo-forum-right">
		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>
<?php
global $post;

// Get terms associated with the forum (taxonomy: location)
$terms = wp_get_post_terms($post->ID, 'location', ['orderby' => 'parent', 'order' => 'ASC']);

if (!empty($terms)) {
    $city_term = null;

    foreach ($terms as $term) {
        if ($term->parent > 0) { // Check if term has a parent
            $parent_term = get_term($term->parent, 'location');
            if ($parent_term && $parent_term->parent > 0) {
                // If the parent itself has a parent, this is a grandchild (City Level)
                $city_term = $term;
                break;
            }
        }
    }

    if ($city_term) { ?>
        <span class="badge badge-primary">
            <a href="<?php echo esc_url(get_term_link($city_term)); ?>" style="color: white; text-decoration: none;">
                <?php echo esc_html($city_term->name); ?>
            </a>
        </span>
    <?php }
} 
?>

			
		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

		<?php bbp_list_forums(); ?>

		<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		<?php bbp_forum_row_actions(); ?>
        </div>    
        </div>    

	</li>

	<li class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></li>

	<li class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></li>
    
    <li class="bbp-forum-freshness">     
        <div class="disputo-freshness-box">
            <div class="disputo-freshness-left">
                <div class="disputo-freshness-name">
                <?php do_action( 'bbp_theme_before_topic_author' ); ?>
                <?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ); ?>
					
					
                <?php do_action( 'bbp_theme_after_topic_author' ); ?>
                </div>
                <div class="disputo-freshness-link">
                <?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>
                <?php bbp_forum_freshness_link(); ?>
                <?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
                </div>
            </div>
            <?php
            $disputo_verified_user = disputo_verified_check(bbp_get_topic_author_id(bbp_get_forum_last_active_id())); 
            $disputo_verified_class = '';
            if ($disputo_verified_user == 'verified') {
                $disputo_verified_class = 'disputo-verified-user';
            }
            ?>
            <div class="disputo-freshness-right <?php echo esc_attr($disputo_verified_class); ?>">
                <?php bbp_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'size' => 45, 'type' => 'avatar' ) ); ?>
            </div>
        </div>
	</li>
</ul>
                        <?php endwhile; ?>
                    </li>
                </ul>

            <?php
                endif;
                wp_reset_postdata();
            }
            ?>

        </div>
    </div>
</main>
<?php
get_footer();
?>