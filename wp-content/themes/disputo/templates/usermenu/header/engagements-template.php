<?php if ( bbp_is_engagements_active() ) : ?>
<a class="dropdown-item" href="<?php bbp_user_engagements_url(wp_get_current_user()->ID); ?>"><?php esc_html_e( 'Engagements', 'disputo' ); ?></a>
<?php endif; ?>