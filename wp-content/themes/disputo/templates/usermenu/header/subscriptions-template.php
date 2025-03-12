<?php if ( bbp_is_subscriptions_active() ) : ?>
<a class="dropdown-item" href="<?php bbp_subscriptions_permalink(wp_get_current_user()->ID); ?>"><?php esc_html_e( 'Subscriptions', 'disputo' ); ?></a>
<?php endif; ?>