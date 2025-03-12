<?php

/**
 * bbPress User Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="form-group">
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="disputo-profile-tab" data-toggle="tab" href="#disputo-profile" role="tab" aria-controls="disputo-profile" aria-selected="true"><?php esc_html_e( 'Profile', 'disputo' ) ?></a>
    </li>
    <?php if (function_exists('cmb2_metabox_form')) { ?>
    <li id="disputo-profile-image-tab-li" class="nav-item">
        <a class="nav-link" id="disputo-profile-image-tab" data-toggle="tab" href="#disputo-profile-image" role="tab" aria-controls="disputo-profile-image" aria-selected="false"><?php esc_html_e( 'Additional Fields', 'disputo' ) ?></a>
    </li>
    <?php } ?>
</ul>    
 <div class="tab-content">
  <div class="tab-pane fade show active" id="disputo-profile" role="tabpanel" aria-labelledby="disputo-profile-tab">
      <form id="bbp-your-profile" action="<?php bbp_user_profile_edit_url( bbp_get_displayed_user_id() ); ?>" method="post" enctype="multipart/form-data">

	<h4><?php esc_html_e( 'Profile', 'disputo' ) ?></h4>

	<?php do_action( 'bbp_user_edit_before' ); ?>

	<fieldset class="bbp-form disputo-edit-profile-section">

		<?php do_action( 'bbp_user_edit_before_name' ); ?>

		<div class="form-row mb-4">
            <div class="col">
                <label for="first_name"><?php esc_html_e( 'First Name', 'disputo' ) ?></label>
                <input type="text" name="first_name" id="first_name" value="<?php bbp_displayed_user_field( 'first_name', 'edit' ); ?>" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
            </div>
            <div class="col">
                <label for="last_name"><?php esc_html_e( 'Last Name', 'disputo' ) ?></label>
                <input type="text" name="last_name" id="last_name" value="<?php bbp_displayed_user_field( 'last_name', 'edit' ); ?>" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
            </div>
		</div>

		<div class="form-row">
            <div class="col">
                <label for="nickname"><?php esc_html_e( 'Nickname', 'disputo' ); ?></label>
                <input type="text" name="nickname" id="nickname" value="<?php bbp_displayed_user_field( 'nickname', 'edit' ); ?>" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
            </div>
            <div class="col">
                <label for="display_name"><?php esc_html_e( 'Display Name', 'disputo' ) ?></label>
                <?php bbp_edit_user_display_name(); ?>
            </div>
		</div>

		<?php do_action( 'bbp_user_edit_after_name' ); ?>

	</fieldset>

	<fieldset class="bbp-form disputo-edit-profile-section">

		<?php do_action( 'bbp_user_edit_before_contact' ); ?>

		<div class="form-group mb-1">
			<label for="url"><?php esc_html_e( 'Website', 'disputo' ) ?></label>
			<input type="text" name="url" id="url" value="<?php bbp_displayed_user_field( 'user_url', 'edit' ); ?>" maxlength="200" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
		</div>

		<?php foreach ( bbp_edit_user_contact_methods() as $name => $desc ) : ?>

			<div class="form-group mb-0">
				<label for="<?php echo esc_attr( $name ); ?>"><?php echo apply_filters( 'user_' . $name . '_label', $desc ); ?></label>
				<input type="text" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ); ?>" value="<?php bbp_displayed_user_field( $name, 'edit' ); ?>" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
			</div>

		<?php endforeach; ?>
        
        <div class="form-group mb-0">
		<?php do_action( 'bbp_user_edit_after_contact' ); ?>
        </div>

	</fieldset>

	<fieldset class="bbp-form disputo-edit-profile-section">

		<?php do_action( 'bbp_user_edit_before_about' ); ?>

		<div class="form-group mb-3">
			<label for="description"><?php esc_html_e( 'Biographical Info', 'disputo' ); ?></label>
			<textarea name="description" class="form-control" id="description" rows="5" cols="30" tabindex="<?php bbp_tab_index(); ?>"><?php bbp_displayed_user_field( 'description', 'edit' ); ?></textarea>
		</div>
        
		<?php do_action( 'bbp_user_edit_after_about' ); ?>

	</fieldset>

	<fieldset class="bbp-form disputo-edit-profile-section">
		<h4><?php esc_html_e( 'Account', 'disputo' ) ?></h4>

		<?php do_action( 'bbp_user_edit_before_account' ); ?>
        
        <div class="form-row mb-3">
            <div class="col">
                <label for="url"><?php esc_html_e( 'Language', 'disputo' ) ?></label>
                <?php bbp_edit_user_language(); ?>
            </div>
            <div class="col">
                <label for="user_login"><?php esc_html_e( 'Username', 'disputo' ); ?></label>
                <input type="text" name="user_login" id="user_login" value="<?php bbp_displayed_user_field( 'user_login', 'edit' ); ?>" disabled="disabled" class="form-control" tabindex="<?php bbp_tab_index(); ?>" />
            </div>
        </div>

		<div class="form-group">
			<label for="email"><?php esc_html_e( 'Email', 'disputo' ); ?></label>

			<input type="text" name="email" id="email" value="<?php bbp_displayed_user_field( 'user_email', 'edit' ); ?>" class="form-control" maxlength="100" tabindex="<?php bbp_tab_index(); ?>" autocomplete="off" />

		</div>

		<?php bbp_get_template_part( 'form', 'user-passwords' ); ?>

		<?php do_action( 'bbp_user_edit_after_account' ); ?>

	</fieldset>

	<?php if ( ! bbp_is_user_home_edit() && current_user_can( 'promote_user', bbp_get_displayed_user_id() ) ) : ?>

		<fieldset class="bbp-form disputo-edit-profile-section">
			<h4><?php esc_html_e( 'User Role', 'disputo' ); ?></h4>

			<?php do_action( 'bbp_user_edit_before_role' ); ?>

			<?php if ( is_multisite() && is_super_admin() && current_user_can( 'manage_network_options' ) ) : ?>

				<div class="form-group">
					<label for="super_admin"><?php esc_html_e( 'Network Role', 'disputo' ); ?></label>
                    <input class="checkbox" class="form-check-inline" type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( bbp_get_displayed_user_id() ) ); ?> tabindex="<?php bbp_tab_index(); ?>" />
						<?php esc_html_e( 'Grant this user super admin privileges for the Network.', 'disputo' ); ?>
				</div>

			<?php endif; ?>

			<?php bbp_get_template_part( 'form', 'user-roles' ); ?>

			<?php do_action( 'bbp_user_edit_after_role' ); ?>

		</fieldset>

	<?php endif; ?>

	<?php do_action( 'bbp_user_edit_after' ); ?>

	<fieldset class="submit">
		<div class="form-group">

			<?php bbp_edit_user_form_fields(); ?>

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_user_edit_submit" name="bbp_user_edit_submit" class="button submit user-submit"><?php bbp_is_user_home_edit() ? esc_html_e( 'Update Profile', 'disputo' ) : esc_html_e( 'Update User', 'disputo' ); ?></button>
		</div>
	</fieldset>

</form>
     </div>
      <div class="tab-pane fade" id="disputo-profile-image" role="tabpanel" aria-labelledby="disputo-profile-image-tab">
          <?php if (function_exists('cmb2_metabox_form')) { ?>
          <?php cmb2_metabox_form( 'disputo_usercover', bbp_get_displayed_user_id(), array('save_button' => esc_html__( 'Save Changes', 'disputo' )) ); ?>
          <?php } ?>
     </div>
</div>