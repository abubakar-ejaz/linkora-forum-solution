<?php
$newtab = '';
if ($instance['newtab'] == 'on') {
    $newtab = 'target="_blank"';
}
?>
<div class="disputo-action-wrapper <?php echo esc_html($instance['position']); ?>">
    <div class="disputo-action-left">
        <?php if (!empty($instance['heading'])) { ?>
        <<?php echo esc_attr($instance['headinglevel']); ?>>
            <?php echo esc_attr($instance['heading']); ?>
        </<?php echo esc_attr($instance['headinglevel']); ?>>
        <?php } ?>
        <?php if (!empty($instance['text'])) { ?>
        <p class="lead"><?php echo esc_attr($instance['text']); ?></p>
        <?php } ?>
    </div>
    <?php if (!empty($instance['destination'])) { ?>
    <div class="disputo-action-right">
        <a href="<?php echo esc_attr($instance['destination']); ?>" class="btn btn-<?php echo esc_attr($instance['buttonstyle']); ?>" <?php echo $newtab; ?>><?php echo esc_attr($instance['buttontext']); ?></a>
    </div>
    <?php } ?>
</div>