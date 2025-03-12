<?php

/**
 * Single Topic Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php do_action( 'bbp_template_before_single_topic' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php bbp_single_topic_description(); ?>

		<?php if ( bbp_show_lead_topic() ) : ?>

			<?php bbp_get_template_part( 'content', 'single-topic-lead' ); ?>

		<?php endif; ?>

		<?php if ( bbp_has_replies() ) : ?>

			<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

			<?php bbp_get_template_part( 'loop',       'replies' ); ?>

			<?php bbp_get_template_part( 'pagination', 'replies' ); ?>

		<?php endif; ?>
    
        <?php bbp_topic_tag_list(); ?>

			<?php 
			$disputo_verified_topic = get_post_meta( get_queried_object_id(), 'disputo_cmb2_topic_verified', true );   
			if ($disputo_verified_topic == 'yes') {
				if (is_user_logged_in()) {
					$disputo_verified_user = disputo_verified_check(get_current_user_ID( 'ID' ));
					if ($disputo_verified_user == 'verified') {
						bbp_get_template_part( 'form', 'reply'); 
					} else {
						echo '<div class="bbp-template-notice danger">' . esc_html__( 'You must be a verified user to reply.', 'disputo') . '</div>';
					}
					
				} else {
					echo '<div class="bbp-template-notice danger">' . esc_html__( 'You must be a verified user to reply.', 'disputo') . '</div>';
				}
			} else {
				bbp_get_template_part( 'form', 'reply'); 
			}
			?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_topic' ); ?>

</div>