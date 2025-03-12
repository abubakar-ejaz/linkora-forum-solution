<?php if ( bbp_is_user_home() ) : ?>
<li class="list-group-item">
    <span class="bbp-user-edit-link">
        <a href="<?php echo wp_logout_url( home_url() ); ?>"><?php esc_html_e( 'Logout', 'disputo' ); ?></a>
    </span>
</li>
<?php endif; ?> 