<?php if ( bbp_is_favorites_active() ) : ?>
<li class="list-group-item <?php if ( bbp_is_favorites() ) : ?>active<?php endif; ?>">
    <span class="bbp-user-favorites-link">
        <a href="<?php bbp_favorites_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Favorites", 'disputo' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Favorites', 'disputo' ); ?></a>
    </span>
</li>
<?php endif; ?>
