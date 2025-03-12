<?php if ( bbp_is_engagements_active() ) : ?>
<li class="list-group-item <?php if ( bbp_is_single_user_engagements() ) : ?>active<?php endif; ?>">
    <span class="bbp-user-engagements-created-link">
        <a href="<?php bbp_user_engagements_url(); ?>" title="<?php printf( esc_attr__( "%s's Engagements", 'disputo' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Engagements', 'disputo' ); ?></a>
    </span>
</li>
<?php endif; ?>
