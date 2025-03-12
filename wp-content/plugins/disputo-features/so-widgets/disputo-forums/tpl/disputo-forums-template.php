<?php if(($instance['forums'] == 0) || (empty($instance['forums']))) { ?>
<?php if (!empty($instance['heading'])) { ?>
<div class="disputo-widget-title">
    <<?php echo esc_attr($instance['headinglevel']); ?>><span><?php echo esc_attr($instance['heading']); ?></span></<?php echo esc_attr($instance['headinglevel']); ?>>
</div>
<?php } ?>
<?php
$disputo_breadcrumbs = '';
$disputo_search = '';
$disputo_thumbnails = '';
if ($instance['thumbnails'] == 'on') {
    $disputo_thumbnail = 'no-thumbnail';
}
if ($instance['breadcrumbs'] == 'on') {
    $disputo_breadcrumbs = 'no-breadcrumbs';
}
if ($instance['search'] == 'on') {
    $disputo_search = 'no-search-box';
}
?>
<div class="disputo-forums-widget <?php echo esc_html($disputo_breadcrumbs); ?> <?php echo esc_html($disputo_search); ?> <?php echo esc_html($disputo_thumbnail); ?>">
<?php echo do_shortcode('[bbp-forum-index]'); ?>
</div>
<?php } else { ?>
<div class="disputo-forums-widget">
    <?php echo do_shortcode('[disputoforum forumid="' . $instance['forums'] . '" maxtopics="' . $instance['maxtopics'] . '" headinglevel="' . $instance['headinglevel'] . '" heading="' . $instance['heading'] . '"]'); ?>
</div>
<?php } ?>