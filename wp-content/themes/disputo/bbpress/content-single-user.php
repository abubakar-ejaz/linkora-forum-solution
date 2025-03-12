<?php

/**
 * Single User Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbpress-forums">
	<?php do_action( 'bbp_template_notices' ); ?>
    <div class="disputo-user-wrapper">
	   <div id="bbp-user-wrapper" class="disputo-user-left">
           <?php bbp_get_template_part( 'user', 'details' ); ?>
	   </div>   
        <div id="bbp-user-body" class="disputo-user-right">
            <?php if ( bbp_is_favorites() ) bbp_get_template_part( 'user', 'favorites' ); ?>
            <?php if ( bbp_is_subscriptions() ) bbp_get_template_part( 'user', 'subscriptions' ); ?>
            <?php if ( bbp_is_single_user_engagements() ) bbp_get_template_part( 'user', 'engagements'     ); ?>
            <?php if ( bbp_is_single_user_topics() ) bbp_get_template_part( 'user', 'topics-created' ); ?>
            <?php if ( bbp_is_single_user_replies() ) bbp_get_template_part( 'user', 'replies-created' ); ?>
            <?php if ( bbp_is_single_user_edit() ) bbp_get_template_part( 'form', 'user-edit' ); ?>
            <?php if ( bbp_is_single_user_profile() ) bbp_get_template_part( 'user', 'profile' ); ?>
<!-- custom by fakhar -->
			
<div >
<h3 class="topic-title">Points & Rewards</h3>
<div class="parent-points"> <h5 class="inner-topic-title" style="margin:0px;">Points</h5>
<?php
echo do_shortcode('[gamipress_user_points]');										
?>
</div>
<div class="parent-points2"> 
	<h5 class="inner-topic-title" style="margin-bottom: 20px;">Badges</h5>
<?php
echo do_shortcode('[gamipress_last_achievements_earned type="member" title_size="h6"]');
echo do_shortcode('[gamipress_last_achievements_earned type="forum-users" title_size="h6"]');
	?> 
	</div>
	</div>
        </div>
    </div>
</div>
