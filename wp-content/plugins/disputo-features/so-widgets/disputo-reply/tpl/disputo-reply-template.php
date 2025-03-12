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
<?php if(!empty($instance['reply'])) { ?>
<div class="disputo-reply-widget <?php echo esc_html($disputo_breadcrumbs); ?>">
<?php echo do_shortcode('[bbp-single-reply id=' . $instance['reply'] . ']'); ?>
</div>
<?php } ?>