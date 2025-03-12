<li class="list-group-item <?php if ( bbp_is_single_user_topics() ) : ?>active<?php endif; ?>">
    <span class='bbp-user-topics-created-link'>
        <a href="<?php bbp_user_topics_created_url(); ?>" title="<?php printf( esc_attr__( "%s's Topics Started", 'disputo' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Topics Started', 'disputo' ); ?></a>
    </span>
</li>
