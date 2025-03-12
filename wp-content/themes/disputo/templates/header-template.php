<nav id="disputo-main-menu-wrapper" class="navbar navbar-expand-lg bg-transparent">
       <div class="container">
           <?php $disputo_blog_title = get_bloginfo( 'name' ); ?>
           <?php 
           if (has_custom_logo()) {
               the_custom_logo();
           } else { ?>
           <a class="navbar-brand" href="<?php echo esc_url(home_url( '/' )); ?>">
               <?php echo esc_attr($disputo_blog_title); ?>
           </a>
           <?php } ?>
           <?php if ( has_nav_menu( 'disputo-main-menu' ) ) { ?>
           <div class="navbar-toggler collapsed" role="button" data-toggle="collapse" data-target="#disputo-main-menu" aria-controls="disputo-main-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'disputo' ); ?>">
               <span class="fa fa-bars"></span> <?php echo esc_html__( 'MENU', 'disputo'); ?>
           </div>
           <?php
            wp_nav_menu([
                'menu'            => '',
                'theme_location'  => 'disputo-main-menu',
                'container'       => 'div',
                'container_id'    => 'disputo-main-menu',
                'container_class' => 'collapse navbar-collapse',
                'menu_id'         => false,
                'menu_class'      => 'nav navbar-nav ml-auto',
                'depth'           => 2,
                'fallback_cb'     => 'bs4navwalker::fallback',
                'walker'          => new bs4navwalker()
            ]);
           ?>
           
           <?php } ?>
           <div id="disputo-header-btns">
           <?php
           $disputo_enable_user_menu = get_theme_mod('disputo_enable_user_menu', 'on');  
           $disputo_enable_woo_icon = get_theme_mod('disputo_enable_woo_icon', 'on');         
           $disputo_login_text = get_theme_mod('disputo_login_text', esc_html__('Login', 'disputo'));
           if ( is_user_logged_in() ) {
                if ( function_exists( 'bbp_user_profile_url' ) ) {
                    $disputo_current_user = wp_get_current_user();
                    $disputo_user_ID = $disputo_current_user->ID;
                    $disputo_display_name = $disputo_current_user->display_name;
           ?>
           <div id="disputo-top-bar-login">
               <div id="disputo-top-bar-btn" class="btn-group" role="group" aria-label="<?php echo esc_attr($disputo_display_name); ?>">
                   <?php if (( class_exists( 'woocommerce' ) ) && ($disputo_enable_woo_icon == 'on')) { ?>
                   <a id="disputo-top-bar-woo-btn" href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-info"><i class="fa fa-shopping-bag"></i><span class="icon-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span></a>
                   <?php } ?>
                   <?php if ($disputo_enable_user_menu == 'on') { ?>
                   <button id="disputo-login-dropdown" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                   <div class="dropdown-menu" aria-labelledby="disputo-login-dropdown">
                       <?php
                       $user_menu_items = get_theme_mod( 'disputo_default_user_menu_items', array( 'high', 'profile', 'mywall', 'myblog', 'messages','medium', 'topics', 'replies', 'engagements', 'favorites', 'subscriptions', 'editprofile', 'shop', 'low', 'logout' ) );   
                       foreach ( $user_menu_items as $user_menu_item ) {
                           get_template_part( 'templates/usermenu/header/' . $user_menu_item, 'template');
                       }
                       ?>
                   </div>
                   <?php } ?>
               </div>
           </div>
           <?php }
           } else {
               $disputo_enable_login = get_theme_mod('disputo_enable_login', 'on');
               $disputo_login_url = get_theme_mod('disputo_login_url');
               $disputo_register_link = get_theme_mod('disputo_register_link');
               $disputo_register_text = get_theme_mod('disputo_register_text', esc_html__('Register', 'disputo'));
               $disputo_register_url = get_theme_mod('disputo_register_url');
               if (empty($disputo_register_url)) {
                $disputo_register_url = wp_registration_url();
               }
               $disputo_lost_password_link = get_theme_mod('disputo_lost_password_link');
               $disputo_lost_password_text = get_theme_mod('disputo_lost_password_text', esc_html__('Lost Password?', 'disputo'));
               $disputo_lost_password_url = get_theme_mod('disputo_lost_password_url');
               if (empty($disputo_lost_password_url)) {
                $disputo_lost_password_url = wp_lostpassword_url();
               }
               if ($disputo_enable_login == 'on') {
                   if (!empty($disputo_login_url)) { ?>
                    <div id="disputo-top-bar-login">
                        <a id="disputo-top-bar-btn" href="<?php echo esc_url($disputo_login_url); ?>" class="btn btn-info">
                            <?php echo esc_html($disputo_login_text); ?>
                        </a>
                    </div>
                    <?php } else { ?>
                        <div id="disputo-top-bar-login-form">
                        <button id="disputo-top-bar-btn" href="#" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo esc_html($disputo_login_text); ?>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="disputo-top-bar-btn">
                            <?php 
                            do_action('disputo_before_login_form');
                            $login_form_args = array(
                                'remember' => false
                            );
                            wp_login_form($login_form_args);
                            do_action('disputo_after_login_form');
                            if ($disputo_register_link || $disputo_lost_password_link) {
                            ?>
                            <div class="disputo-login-form-links">
                            <?php if ($disputo_register_link && get_option('users_can_register') == 1) { ?>
                                <a href="<?php echo esc_url($disputo_register_url); ?>"><?php echo esc_html($disputo_register_text); ?></a>
                            <?php } ?>
                            <?php if ($disputo_lost_password_link) { ?>
                                <a href="<?php echo esc_url($disputo_lost_password_url); ?>"><?php echo esc_html($disputo_lost_password_text); ?></a>
                            <?php } ?>
                            <?php do_action('disputo_login_form_link'); ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php }
                }
            } ?>
           </div>
           <div class="clear"></div>
       </div>
</nav>