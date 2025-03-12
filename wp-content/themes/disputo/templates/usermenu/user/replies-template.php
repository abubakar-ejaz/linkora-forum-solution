<li class="list-group-item <?php if ( bbp_is_single_user_replies() ) : ?>active<?php endif; ?>">
    <span class='bbp-user-replies-created-link'>
        <a href="<?php bbp_user_replies_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Replies Created", 'disputo' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Replies Created', 'disputo' ); ?></a>
    </span>
</li>
