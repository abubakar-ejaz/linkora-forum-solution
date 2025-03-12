<?php

/**
 * User Profile
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_user_profile' ); ?>

<?php if ( !get_query_var( 'BPT_tab' ) ) { ?> 

<div class="disputo-before-user-profile">
<?php do_action( 'disputo_before_user_profile' ); ?>
</div>   

<div id="bbp-user-profile" class="bbp-user-profile">
    <div class="disputo-user-boxes">
    <div class="disputo-user-box bbp-user-forum-role">
        <div class="disputo-user-box-icon">
            <div class="disputo-user-box-icon-inner">
                <i class="fa fa-user"></i>
            </div>
        </div>
        <?php $user_role = bbp_get_user_role( bbp_get_user_id() ); ?>
        <div class="disputo-user-box-info disputo-user-<?php echo esc_attr($user_role); ?>">
            <h5><?php esc_html_e( 'Forum Role', 'disputo' ); ?></h5>
            <p><span class="badge badge-info"><?php bbp_user_display_role(); ?></span></p>
        </div>
    </div>   
    <div class="disputo-user-box center-box bbp-user-topic-count">
        <div class="disputo-user-box-icon">
            <div class="disputo-user-box-icon-inner">
                <i class="fa fa-comment"></i>
            </div>
        </div>
        <div class="disputo-user-box-info">
            <h5><?php esc_html_e( 'Topics Started', 'disputo' ); ?></h5>
            <p><span class="badge badge-primary"><?php echo esc_html(bbp_get_user_topic_count_raw()); ?></span></p>
        </div>
    </div>
    <div class="disputo-user-box">
        <div class="disputo-user-box-icon">
            <div class="disputo-user-box-icon-inner">
                <i class="fa fa-comments"></i>
            </div>
        </div>
        <div class="disputo-user-box-info">
            <h5><?php esc_html_e( 'Replies Created', 'disputo' ); ?></h5>
            <p><span class="badge badge-primary"><?php echo esc_html(bbp_get_user_reply_count_raw()); ?></span></p>
        </div>
    </div>
</div>

<?php $disputo_author_has_post = count_user_posts(bbp_get_user_id()); ?>    
    
<?php if ((bbp_get_displayed_user_field( 'first_name' )) || (bbp_get_displayed_user_field( 'last_name' )) || (bbp_get_displayed_user_field( 'description' )) || (bbp_get_displayed_user_field( 'user_url' )) || ($disputo_author_has_post != 0)) { ?>   
    <ul class="disputo-user-list-group list-group">       
        <?php if ((bbp_get_displayed_user_field( 'first_name' )) || (bbp_get_displayed_user_field( 'last_name' ))) { ?>
        <li class="bbp-user-name list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Name', 'disputo' ); ?>:</strong> <?php echo esc_html(bbp_get_displayed_user_field( 'first_name' )); ?> <?php echo esc_html(bbp_get_displayed_user_field( 'last_name' )); ?></p>
        </li>
        <?php } ?> 
        <?php 
        $disputo_user_date_of_birth = get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_date_of_birth', true ); 
        if ($disputo_user_date_of_birth) {
        $disputo_user_birthday = new DateTime($disputo_user_date_of_birth);
        $disputo_user_now = new DateTime();
        $disputo_user_age = $disputo_user_now->diff($disputo_user_birthday);
        ?>
        <li class="bbp-user-name list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Age', 'disputo' ); ?>:</strong> <?php echo esc_html($disputo_user_age->y); ?></p>
        </li>
        <?php } ?>  
        <?php 
        $disputo_user_gender = get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_gender', true ); 
        if ($disputo_user_gender) {
            if ( $disputo_user_gender == 'male') {
                $disputo_user_gender = esc_html__( 'Male', 'disputo' );
            } else {
                $disputo_user_gender = esc_html__( 'Female', 'disputo' );
            }
        ?>
        <li class="bbp-user-name list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Gender', 'disputo' ); ?>:</strong> <?php echo esc_html($disputo_user_gender); ?></p>
        </li>
        <?php } ?>
        
        <?php 
        $disputo_user_location = get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_location', true ); 
        $disputo_user_flag = get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_flag', true ); 
        $disputo_bbpress_flags = get_theme_mod('disputo_bbpress_flags');
        if (($disputo_user_location) || ($disputo_user_flag)) {
        ?>
        <li class="bbp-user-name list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Location', 'disputo' ); ?>: </strong> 
            <?php if (($disputo_user_flag) && ($disputo_bbpress_flags)) { ?>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/blank.gif" class="flag flag-<?php echo esc_attr(strtolower($disputo_user_flag)); ?>" alt="<?php echo esc_attr($disputo_user_flag); ?>" /><?php } ?><?php echo esc_html($disputo_user_location); ?>
            </p>
        </li>
        <?php } ?>
        
        <?php if ( bbp_get_displayed_user_field( 'description' ) ) { ?>
        <li class="bbp-user-description list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Biographical Info', 'disputo' ); ?>:</strong> </p>
            <p class="mt-3 font-italic"><?php echo bbp_rel_nofollow( bbp_get_displayed_user_field( 'description' ) ); ?></p>
        </li>
        <?php } ?>
        
        <?php if ( bbp_get_displayed_user_field( 'user_url' ) ) { ?>
        <?php $disputo_author_url = str_replace(array( 'http://', 'https://' ), '', bbp_get_displayed_user_field( 'user_url' )); ?>
        <li class="bbp-user-website list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Website', 'disputo' ); ?>:</strong> <a href="<?php echo esc_url(bbp_get_displayed_user_field( 'user_url' )); ?>" rel="nofollow" target="_blank"><?php echo esc_html($disputo_author_url); ?></a></p>
        </li>
        <?php } ?>
        
        <?php if ( $disputo_author_has_post != 0 ) { ?>
        <?php $disputo_author_blog = get_author_posts_url(bbp_get_user_id()); ?>
        <?php $disputo_author_blog_url = str_replace(array( 'http://', 'https://' ), '', $disputo_author_blog); ?>
        <li class="bbp-user-blog list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p><strong class="text-primary"><?php esc_html_e( 'Blog', 'disputo' ); ?>:</strong> <a href="<?php echo esc_url($disputo_author_blog); ?>" target="_blank"><?php echo esc_html($disputo_author_blog_url); ?></a></p>
            </div>
            <span class="badge badge-primary badge-pill"><?php echo esc_html($disputo_author_has_post); ?></span>
        </li>
        <?php } ?>
        
        <li class="bbp-user-registered list-group-item">
            <p><strong class="text-primary"><?php esc_html_e( 'Registered', 'disputo' ); ?>:</strong> <?php echo bbp_get_time_since( bbp_get_displayed_user_field( 'user_registered' ) ) ?></p>
        </li> 

        <?php do_action('disputo_profile_list_item'); ?>
        
        <?php
        $disputo_user_icons = get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2user_icons', true );
        $disputo_bbpress_social_icons = get_theme_mod('disputo_bbpress_social_icons');
        if ( $disputo_user_icons && $disputo_bbpress_social_icons ) {
        ?>
        <li class="bbp-user-socialmedia list-group-item">
            <ul class="disputo-social-icons">
            <?php 
            foreach ( (array) $disputo_user_icons as $key => $entry ) { 
                $disputoiconimg = $disputoiconlink  = '';
                if ( isset( $entry['disputo_cmb2iconimg'] ) ) {            
                    $disputoiconimg = $entry['disputo_cmb2iconimg'];
                }
                if ( isset( $entry['disputo_cmb2iconlink'] ) ) {            
                    $disputoiconlink = $entry['disputo_cmb2iconlink'];
                } 
                ?>
                <li><a class="bg-info text-white" href="<?php echo esc_url($disputoiconlink); ?>" target="_blank" rel="nofollow"><i class="fa fa-<?php echo esc_attr($disputoiconimg); ?>"></i></a></li>
            <?php } ?>
            </ul>
            <div class="clearfix"></div>
        </li>
        <?php } ?>     
    </ul>
</div>
<?php } ?>
<?php } ?>
<div class="disputo-after-user-profile">
<?php do_action( 'disputo_after_user_profile' ); ?>
</div>
<?php do_action( 'bbp_template_after_user_profile' ); ?>