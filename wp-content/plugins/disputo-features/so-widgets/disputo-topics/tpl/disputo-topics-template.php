<?php if (!empty($instance['heading'])) { ?>
<div class="disputo-widget-title">
    <<?php echo esc_attr($instance['headinglevel']); ?>><span><?php echo esc_attr($instance['heading']); ?></span></<?php echo esc_attr($instance['headinglevel']); ?>>
</div>
<?php } ?>
<?php
$disputo_breadcrumbs = '';
if ($instance['breadcrumbs'] == 'on') {
    $disputo_breadcrumbs = 'no-breadcrumbs';
}
?>
<div class="disputo-topics-widget <?php echo esc_html($disputo_breadcrumbs); ?>">
<?php
if(($instance['topics'] == 0) || (empty($instance['topics']))) {
    echo do_shortcode('[bbp-topic-index]');
} else {
    echo do_shortcode('[bbp-single-topic id=' . $instance['topics'] . ']');
}
?>
</div>    