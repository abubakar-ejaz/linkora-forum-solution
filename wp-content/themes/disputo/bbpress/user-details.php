<?php

/**
 * User Details
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php do_action( 'bbp_template_before_user_details' ); ?>
<?php
$disputo_bbpress_user_avatar = get_theme_mod('disputo_bbpress_user_avatar');
$custom_avatar = get_user_meta(bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_user_avatar' );
$custom_avatar_img = wp_get_attachment_image_src( get_user_meta( bbp_get_displayed_user_field( 'ID' ), 'disputo_cmb2_user_avatar_id', 1 ), 'thumbnail' );
?>
	<div id="bbp-single-user-details">
        <?php
        $disputo_verified_user = disputo_verified_check(bbp_get_displayed_user_field( 'ID' )); 
        $disputo_verified_class = '';
        $disputo_verified_title = '';
        if ($disputo_verified_user == 'verified') {
            $disputo_verified_class = 'disputo-verified-user';
            $disputo_verified_title = esc_html__( 'Verified User', 'disputo' ); 
        }
        ?>
        <?php if ($disputo_bbpress_user_avatar && $custom_avatar) { ?>
		<div id="bbp-user-avatar" class="<?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
            <a href="<?php bbp_user_profile_url(); ?>" title="<?php bbp_displayed_user_field( 'display_name' ); ?>">
                <img src="<?php echo esc_url($custom_avatar_img[0]); ?>" alt="<?php bbp_displayed_user_field( 'display_name' ); ?>" />
            </a>
		</div>
        <?php } else { ?>
        <div id="bbp-user-avatar" class="<?php echo esc_attr($disputo_verified_class); ?>" title="<?php echo esc_attr($disputo_verified_title); ?>">
            <a href="<?php bbp_user_profile_url(); ?>" title="<?php bbp_displayed_user_field( 'display_name' ); ?>">
                <?php echo get_avatar( bbp_get_displayed_user_field( 'user_email', 'raw' ), apply_filters( 'bbp_single_user_details_avatar_size', 150 ) ); ?>
            </a>
		</div>
        <?php } ?>
        <?php 
        $usernav = '';
        if ( !bbp_is_user_home() ) { 
            $usernav = 'bbp-user-navigation-hide';
        }
        ?>
		<div id="bbp-user-navigation" class="<?php echo esc_attr($usernav); ?>">
			<ul class="list-group">
                <?php
                $user_menu_items = get_theme_mod( 'disputo_default_user_menu_items', array( 'high', 'profile', 'myblog', 'messages','medium', 'topics', 'replies', 'engagements', 'favorites', 'subscriptions', 'editprofile', 'shop', 'low', 'logout' ) );   
                foreach ( $user_menu_items as $user_menu_item ) {
                    get_template_part( 'templates/usermenu/user/' . $user_menu_item, 'template');
                }
                ?>   
			</ul>
		</div>
	</div>
	<?php do_action( 'bbp_template_after_user_details' ); ?>