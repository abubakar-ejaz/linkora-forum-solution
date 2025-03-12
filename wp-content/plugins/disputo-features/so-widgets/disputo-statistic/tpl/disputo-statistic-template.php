<?php
$fontsize = $instance['a_section']['fontsize'];
$fontcolor = $instance['a_section']['fontcolor'];
$iconcolor = $instance['b_section']['iconcolor'];
$iconbgcolor = $instance['b_section']['iconbgcolor'];
$iconfontsize = $instance['b_section']['iconfontsize'];
$icontainersize = $instance['b_section']['iconcontainersize'];
$iconurl = $instance['b_section']['iconurl'];
?>
<div class="disputo-statistic" style="font-size:<?php echo esc_html($fontsize); ?>rem;color:<?php echo esc_html($fontcolor); ?>;">
    <div class="disputo-statistic-icon" style="width:<?php echo esc_html($icontainersize); ?>px;">
        <div class="disputo-statistic-icon-inner" style="font-size:<?php echo esc_html($iconfontsize); ?>px;color:<?php echo esc_html($iconcolor); ?>;background-color:<?php echo esc_html($iconbgcolor); ?>;height:<?php echo esc_html($icontainersize); ?>px;line-height:<?php echo esc_html($icontainersize); ?>px;">
            <?php if ($iconurl) { ?>
            <a href="<?php echo sow_esc_url($iconurl); ?>" style="color:<?php echo esc_html($iconcolor); ?>">
                <?php echo siteorigin_widget_get_icon($instance['b_section']['icon']); ?>
            </a>
            <?php } else { ?>
            <?php echo siteorigin_widget_get_icon($instance['b_section']['icon']); ?>
            <?php } ?>  
        </div>
    </div>
    <div class="disputo-statistic-number">
        <div class="disputo-statistic-title">
            <?php echo esc_html($instance['a_section']['title']); ?>
        </div>
        <?php 
            if ($instance['a_section']['statistic'] == 'posts') {
                disputo_post_count();
            } elseif($instance['a_section']['statistic'] == 'comments') {
                disputo_comment_count();
            } elseif($instance['a_section']['statistic'] == 'users') {
                disputo_bbpress_user_count();
            } elseif($instance['a_section']['statistic'] == 'forums') {
                disputo_bbpress_forum_count();
            } elseif($instance['a_section']['statistic'] == 'topics') {
                disputo_bbpress_topic_count();
            } elseif($instance['a_section']['statistic'] == 'replies') {
                disputo_bbpress_reply_count();
            } elseif($instance['a_section']['statistic'] == 'topic_tags') {
                disputo_bbpress_topic_tag_count();
            } elseif($instance['a_section']['statistic'] == 'likes') {
                disputo_like_count();
            } elseif($instance['a_section']['statistic'] == 'dislikes') {
                disputo_dislike_count();
            } elseif($instance['a_section']['statistic'] == 'woo') {
                disputo_product_count();
            }
        ?>
    </div>
</div>