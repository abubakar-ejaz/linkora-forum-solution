<?php if ( bbp_is_user_home() || current_user_can( 'edit_user', bbp_get_displayed_user_id() ) ) : ?>
<?php if ( bbp_is_subscriptions_active() ) : ?>
<li class="list-group-item <?php if ( bbp_is_subscriptions() ) : ?>active<?php endif; ?>">
    <span class="bbp-user-subscriptions-link">
        <a href="<?php bbp_subscriptions_permalink(); ?>" title="<?php printf( esc_attr__( "%s's Subscriptions", 'disputo' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Subscriptions', 'disputo' ); ?></a>
    </span>
</li>
<?php endif; ?>
<?php endif; ?> 