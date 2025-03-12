<?php if (!empty($instance['heading'])) { ?>
<div class="disputo-forum-widget-title">
    <div class="disputo-forum-widget-left">
    <<?php echo esc_attr($instance['headinglevel']); ?>><?php echo esc_attr($instance['heading']); ?></<?php echo esc_attr($instance['headinglevel']); ?>>
    </div>
</div>
<?php } ?>
<div class="disputo-forum-widget-wrapper">          
<?php echo do_shortcode('[bbp-single-view id="disputo-popular-topics"]'); ?>
</div>    