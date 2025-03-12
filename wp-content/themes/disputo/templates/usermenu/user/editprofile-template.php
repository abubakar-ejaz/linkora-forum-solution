<?php if ( bbp_is_user_home() || current_user_can( 'edit_user', bbp_get_displayed_user_id() ) ) : ?>
<li class="list-group-item <?php if ( bbp_is_single_user_edit() ) :?>active<?php endif; ?>">
    <span class="bbp-user-edit-link">
        <a href="<?php bbp_user_profile_edit_url(); ?>" title="<?php printf( esc_attr__( "Edit %s's Profile", 'disputo' ), bbp_get_displayed_user_field( 'display_name' ) ); ?>"><?php esc_html_e( 'Edit Profile', 'disputo' ); ?></a>
    </span>
</li>
<?php endif; ?>
