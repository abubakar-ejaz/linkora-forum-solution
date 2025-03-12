<?php global $bbpm_message; $m = (object) apply_filters('bbpm_message_data', $bbpm_message);

?>

<li class="bbpm-item bbpm-message <?php echo implode(' ', $m->classes); ?>">
    <div class="bbpm-user-loop no-link">
    <div class="bbpm-icon">
    <?php echo bbpm_profile_linkit($m->sender, get_avatar($m->sender, 90)); ?>
    </div>

    <div class="bbpm-details">
        
        <span class="bbpm-left">
                
            <?php echo bbpm_profile_linkit($m->sender, sprintf(
                '<h5 class="bbpm-heading">%s</h5>',
                $m->sender_data->display_name
            )); ?>

            <span class="bbpm-message">
                <?php echo apply_filters('bbpm_message', $m->message, $m); ?>
            </span>

        </span>

        <span class="bbpm-right">
            <input type="checkbox" name="messages[]" value="<?php echo $m->id; ?>" />
            <span class="bbpm-time" title="<?php echo bbpm_date($m->date); ?>">
                <?php echo bbpm_time_diff($m->date, null, null); ?>
            </span>
        </span>

    </div>
    </div>
</li>