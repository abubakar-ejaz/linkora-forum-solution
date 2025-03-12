<?php
/* Register blog menu item */

function disputo_myblog_menu_item() {
    if (is_user_logged_in()) {
        echo '<a class="dropdown-item" href="' . esc_url(bbp_get_user_profile_url(get_current_user_id())) . 'my-blog">' . esc_html__('My Blog', 'disputo') . '</a>';
    }
}

add_action ('disputo_myblog_link', 'disputo_myblog_menu_item');

/* Register blog tab */

function disputo_register_blog_tab() {
    return \bbPressProfileTabs::create(
        [
            'slug' => 'my-blog',
            'menu-item-text' => esc_html__( 'My Blog', 'disputo'),
            'menu-item-position' => 1,
            'visibility' => 'profile-owner'
        ]
    );
}
add_action('plugins_loaded', 'disputo_register_blog_tab');

add_action( "BPT_content-my-blog", function() {
    
$disputo_enable_user_blog = get_theme_mod('disputo_enable_user_blog');
$disputo_verified = get_theme_mod('disputo_user_blog_verified');
$disputo_max_posts = get_theme_mod('disputo_max_user_blog_post', 20);

if (($disputo_enable_user_blog) && (bbp_is_user_home())) {
    if ( function_exists( 'disputo_add_new_post_form' ) ) { 
        $disputo_verified_user = 'verified';
        if ($disputo_verified) {
            $disputo_verified_user = disputo_verified_check(bbp_get_user_id());
        }
		if ($disputo_verified_user == 'verified') {
        ?>
    <div class="disputo-user-blog-wrapper">
        <h2><?php esc_html_e( 'My Blog', 'disputo' ); ?></h2>     
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="addNewPost-tab" data-toggle="tab" href="#addNewPost" aria-controls="addNewPost" aria-selected="true"><?php esc_html_e( 'Add New Post', 'disputo' ); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="publishedPosts-tab" data-toggle="tab" href="#publishedPosts" aria-controls="publishedPosts" aria-selected="false"><?php esc_html_e( 'Published Posts', 'disputo' ); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pendingPosts-tab" data-toggle="tab" href="#pendingPosts" aria-controls="pendingPosts" aria-selected="false"><?php esc_html_e( 'Pending Posts', 'disputo' ); ?></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="addNewPost" role="tabpanel" aria-labelledby="addNewPost-tab">
                <?php disputo_add_new_post_form(); ?>
            </div>
            <div class="tab-pane fade" id="publishedPosts" role="tabpanel" aria-labelledby="publishedPosts-tab">
                <?php
                $disputo_published_query = new WP_Query( 
                    array('author' => bbp_get_user_id(),'post_type' => 'post', 'posts_per_page' => $disputo_max_posts,'post_status' => 'publish') 
                );
                if ( $disputo_published_query->have_posts() ) {
                while($disputo_published_query->have_posts()) : $disputo_published_query->the_post(); ?>
                <div class="disputo-pending-outer">
                    <?php if (current_user_can('delete_posts')) { ?>
                    <a class="disputo-delete-post-btn" href="<?php echo esc_url(get_delete_post_link( get_the_ID(), '', true )); ?> "><i class="fa fa-times-circle"></i></a>
                    <?php } ?>
                    <div class="disputo-pending-inner">
                        <?php 
                        if (has_post_thumbnail()) { 
                            $disputo_thumb_id = get_post_thumbnail_id();
                            $disputo_thumb_url_array = wp_get_attachment_image_src($disputo_thumb_id, 'thumbnail', true);
                            $disputo_thumb_url = $disputo_thumb_url_array[0]; 
                        ?>
                        <div class="disputo-pending-img">
                            <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($disputo_thumb_url); ?>" alt="<?php the_title(); ?>" /></a>
                        </div>
                        <?php } ?>
                        <div class="disputo-pending">
                            <div class="disputo-pending-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                            <div class="disputo-pending-meta">
                                <i class="fa fa-clock-o"></i> <?php echo the_time(get_option('date_format')); ?>
                            </div>
                            <div class="disputo-pending-desc">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php $disputo_author_blog = get_author_posts_url(bbp_get_user_id()); ?>
                <div class="disputo-user-blog-btn"><a href="<?php echo esc_url($disputo_author_blog); ?>" class="btn btn-primary"><?php esc_html_e( 'View All Posts', 'disputo' ); ?></a></div>
                <?php } else { ?>
                <div class="bbp-template-notice info no-margin">
                    <p><?php esc_html_e('There were no posts found.', 'disputo'); ?></p>
                </div>
                <?php } wp_reset_postdata(); ?>
            </div>
            <div class="tab-pane fade" id="pendingPosts" role="tabpanel" aria-labelledby="pendingPosts-tab">
                <?php
                $disputo_query = new WP_Query( 
                    array('author' => bbp_get_user_id(),'post_type' => 'post', 'posts_per_page' => $disputo_max_posts,'post_status' => 'pending') 
                );
                if ( $disputo_query->have_posts() ) {
                while($disputo_query->have_posts()) : $disputo_query->the_post(); ?>
                <div class="disputo-pending-outer">
                    <?php if (current_user_can('delete_posts')) { ?>
                    <a class="disputo-delete-post-btn" href="<?php echo esc_url(get_delete_post_link( get_the_ID(), '', true )); ?> "><i class="fa fa-times-circle"></i></a>
                    <?php } ?>
                    <div class="disputo-pending-inner">
                        <?php 
                        if (has_post_thumbnail()) { 
                            $disputo_thumb_id = get_post_thumbnail_id();
                            $disputo_thumb_url_array = wp_get_attachment_image_src($disputo_thumb_id, 'thumbnail', true);
                            $disputo_thumb_url = $disputo_thumb_url_array[0]; 
                        ?>
                        <div class="disputo-pending-img">
                            <img src="<?php echo esc_url($disputo_thumb_url); ?>" alt="<?php the_title(); ?>" />
                        </div>
                        <?php } ?>
                        <div class="disputo-pending">
                            <div class="disputo-pending-title">
                                <?php the_title(); ?>
                            </div>
                            <div class="disputo-pending-meta">
                                <i class="fa fa-clock-o"></i> <?php echo the_time(get_option('date_format')); ?>
                            </div>
                            <div class="disputo-pending-desc">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php } else { ?>
                <div class="bbp-template-notice info no-margin">
                    <p><?php esc_html_e('There were no posts found.', 'disputo'); ?></p>
                </div>
                <?php } wp_reset_postdata(); ?>
            </div>
        </div>   
    </div>
    <?php } else {
        echo '<div class="alert alert-warning">' . esc_html__('Only verified users can submit blog post.', 'disputo') . '</div>';
    }
    }
}    
   
});