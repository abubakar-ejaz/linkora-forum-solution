<?php

/**
 * Single Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div id="bbpress-forums">

	<?php bbp_breadcrumb(); ?>

	<?php do_action( 'bbp_template_before_single_forum' ); ?>

	<?php if ( post_password_required() ) : ?>

		<?php bbp_get_template_part( 'form', 'protected' ); ?>

	<?php else : ?>

		<?php bbp_single_forum_description(); ?>

		<?php if ( bbp_has_forums() ) : ?>

			<?php bbp_get_template_part( 'loop', 'forums' ); ?>

		<?php endif; ?>

		<?php if ( !bbp_is_forum_category() && bbp_has_topics() ) : ?>

			<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

			<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

			<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>
    
            <?php bbp_forum_subscription_link(); ?>

			<?php 
			$disputo_verified_topic = get_post_meta( get_queried_object_id(), 'disputo_cmb2_topic_verified', true );   
			if ($disputo_verified_topic == 'yes') {
				if (is_user_logged_in()) {
					$disputo_verified_user = disputo_verified_check(get_current_user_ID( 'ID' ));
					if ($disputo_verified_user == 'verified') {
						bbp_get_template_part( 'form', 'topic'); 
					} else {
						echo '<div class="bbp-template-notice danger">' . esc_html__( 'You must be a verified user to create a new topic.', 'disputo') . '</div>';
					}
					
				} else {
					echo '<div class="bbp-template-notice danger">' . esc_html__( 'You must be a verified user to create a new topic.', 'disputo') . '</div>';
				}
			} else {
				bbp_get_template_part( 'form', 'topic'); 
			}
			?>

		<?php elseif ( !bbp_is_forum_category() ) : ?>

			<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

			<?php 
			$disputo_verified_topic = get_post_meta( get_queried_object_id(), 'disputo_cmb2_topic_verified', true );   
			if ($disputo_verified_topic == 'yes') {
				if (is_user_logged_in()) {
					$disputo_verified_user = disputo_verified_check(get_current_user_ID( 'ID' ));
					if ($disputo_verified_user == 'verified') {
						bbp_get_template_part( 'form', 'topic'); 
					} else {
						echo '<div class="bbp-template-notice danger">' . esc_html__( 'You must be a verified user to create a new topic.', 'disputo') . '</div>';
					}
					
				} else {
					echo '<div class="bbp-template-notice danger">' . esc_html__( 'You must be a verified user to create a new topic.', 'disputo') . '</div>';
				}
			} else {
				bbp_get_template_part( 'form', 'topic'); 
			}
			?>

		<?php endif; ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_single_forum' ); ?>

</div>