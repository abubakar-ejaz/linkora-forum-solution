<?php

/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_lead_topic' ); ?>

<ul class="disputo-replies-bar">
    <li class="disputo-replies-title">
        <?php esc_html_e( 'Post', 'disputo' ); ?>
    </li>
    <li class="disputo-replies-links">
        <span class="disputo-replies-subscription"><?php bbp_topic_subscription_link(array('before' => '','after' => '')); ?></span>
        <span class="disputo-replies-favorites"><?php bbp_topic_favorite_link(); ?></span>
    </li>
</ul>

<ul id="topic-<?php bbp_topic_id(); ?>-lead" class="forums bbp-lead">
    <li>
        <div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class(); ?>>
        <div class="disputo-replies-content-bar">
        <ul class="disputo-replies-content-bar-left">
            <li>
                <span class="bbp-topic-post-date"><i class="fa fa-clock-o"></i> <?php bbp_topic_post_date(); ?></span>
            </li>   
        </ul>
        <ul class="disputo-replies-content-bar-right">
            <?php 
            if ( is_user_logged_in() ) {
                $admin_link_args = array('before' => '<li>','after' => '</li>', 'sep' => '</li><li>');
                bbp_topic_admin_links($admin_link_args);
            } 
            ?> 
            <?php $disputo_quote_check = get_theme_mod('disputo_bbpress_quote'); ?>
            <?php if ($disputo_quote_check) { ?>
            <li>
                <a class="disputo-get-quote" data-author="<?php echo esc_attr(bbp_get_topic_author_display_name(bbp_get_topic_id())); ?>" data-quote="disputo-quote-<?php bbp_topic_id(); ?>" data-url="#" href="#"><?php esc_html_e("Quote", "disputo"); ?></a>
            </li>
            <?php } ?>
            <li>
                <a href="<?php bbp_topic_permalink(); ?>" class="bbp-topic-permalink"><i class="fa fa-chain"></i></a>
            </li>
        </ul>
        </div>
            <div class="disputo-replies-wrapper">
                <?php $user_role = bbp_get_user_role( bbp_get_topic_author_id() ); ?>
                <div class="disputo-replies-author disputo-user-<?php echo esc_attr($user_role); ?>">
                    <?php
                    $disputo_verified_user = disputo_verified_check(bbp_get_reply_author_id()); 
                    $disputo_verified_class = '';
                    $disputo_verified_title = '';
                    if ($disputo_verified_user == 'verified') {
                        $disputo_verified_class = 'disputo-verified-user';
                        $disputo_verified_title = esc_html__( 'Verified User', 'disputo' ); 
                    }
                    ?>
                    <div class="disputo-replies-author-img <?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
                        <?php do_action( 'bbp_theme_before_topic_author_details' ); ?>
                        <?php bbp_topic_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'avatar' ) ); ?>
                    </div>
                    <div class="disputo-replies-author-info">
                        <?php bbp_topic_author_link( array( 'sep' => '', 'show_role' => true, 'type' => 'name' ) ); ?>       
                        <?php
                        $disputo_bbpress_flags = get_theme_mod('disputo_bbpress_flags');
                        $disputo_user_flag = get_user_meta( bbp_get_topic_author_id(), 'disputo_cmb2_flag', true ); 
                        $disputo_follow_user = get_theme_mod('disputo_bbpress_follow_user');
                        $disputo_follow_info = '';
                        if ($disputo_follow_user) {
                            $followers = get_user_meta(bbp_get_reply_author_id(),'bbpress_followers',true);
                            $following = get_user_meta(bbp_get_reply_author_id(),'bbpress_following',true);
                            if (empty($followers)) {
                                $followers = '0';
                            }
                            if (empty($following)) {
                                $following = '0';
                            }
                            $disputo_follow_info = '<br>' . esc_html( 'Followers', 'disputo') . ': ' . $followers . '<br>' . esc_html( 'Following', 'disputo') . ': ' . $following;
                        }
                        if ($disputo_bbpress_flags && $disputo_user_flag) {
                        ?>
                        <div class="disputo-user-location">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/blank.gif" class="flag flag-<?php echo esc_attr(strtolower($disputo_user_flag)); ?>" alt="<?php echo esc_attr($disputo_user_flag); ?>" />
                        </div>
                        <?php } ?>
                        <a tabindex="0" class="disputo-popover" data-container="body" data-trigger="focus" data-toggle="popover" data-placement="bottom" data-content="<?php esc_attr_e( 'Topics Started', 'disputo' ); ?>: <?php echo esc_attr(bbp_get_user_topic_count_raw(bbp_get_topic_author_id())); ?><br><?php esc_attr_e( 'Replies Created', 'disputo' ); ?>: <?php echo esc_attr(bbp_get_user_reply_count_raw(bbp_get_topic_author_id())); ?><?php echo $disputo_follow_info; ?>" data-original-title="<?php esc_attr_e( 'Statistics', 'disputo') ?>"><i class="fa fa-bar-chart"></i></a>
                        <?php if ( bbp_is_user_keymaster() ) : ?>
                        <?php do_action( 'bbp_theme_before_topic_author_details' ); ?>
                        <div class="bbp-topic-ip"><?php bbp_author_ip( bbp_get_topic_id() ); ?></div>
                        <?php do_action( 'bbp_theme_after_topic_author_admin_details' ); ?>
                        <?php endif; ?>
                        <?php do_action( 'bbp_theme_after_topic_author_details' ); ?>
                    </div>
                </div>    
                <div class="disputo-replies-content">
                    <div class="disputo-reply-wrapper">
                        <?php do_action( 'bbp_theme_before_topic_content' ); ?>
                        <?php bbp_topic_content(); ?>
                        <?php do_action( 'bbp_theme_after_topic_content' ); ?>
                    </div>
                </div>
            </div>
        </div>       
    </li>
</ul>

<?php do_action( 'bbp_template_after_lead_topic' ); ?>