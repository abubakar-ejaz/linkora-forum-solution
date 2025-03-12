<div class="disputo-author-box">
    <div class="disputo-author-row">
        <div class="disputo-author-avatar">
            <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
            </a>
        </div>
        <div class="disputo-author-meta">
                <h3><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"><?php the_author(); ?></a></h3>
            <div class="disputo-author-desc">
                <?php echo wp_kses_post(wpautop(get_the_author_meta('description'))); ?>
            </div>
            <div class="disputo-author-menu">
            <?php
        $disputo_user_icons = get_user_meta( get_the_author_meta( 'ID' ), 'disputo_cmb2user_icons', true );
        $disputo_bbpress_social_icons = get_theme_mod('disputo_bbpress_social_icons');
        if ( $disputo_user_icons && $disputo_bbpress_social_icons ) {
        ?>
        <div class="disputo-author-icons">
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
        </div>
        <?php } ?>  
            
            <div class="disputo-author-links">
                <?php if (function_exists('bbp_user_profile_url')) { ?>
                <a class="btn btn-sm btn-primary" href="<?php bbp_user_profile_url(get_the_author_meta( 'ID' )); ?>">
                <?php esc_html_e( 'View Profile', 'disputo'); ?>
                </a>
                <?php } ?>
                <a class="btn btn-sm btn-primary" href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>">
                <?php esc_html_e( 'View all posts by', 'disputo'); ?> <?php the_author(); ?>
                </a>
            </div>
            </div>
        </div>
    </div>
</div>