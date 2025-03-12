<?php global $bbpm_chat; $chat = (object) apply_filters('bbpm_chat_data', $bbpm_chat);
?>

<li class="bbpm-item bbpm-chat <?php echo implode(' ', $chat->classes); ?>" data-chatid="<?php echo $chat->chat_id; ?>">
    
    <div class="bbpm-user-loop" data-chatid="<?php echo $chat->chat_id; ?>">

    <div class="bbpm-details">
        <h5 class="bbpm-heading"><?php echo esc_attr($chat->name); ?></h5>
        <p class="bbpm-excerpt">
            <?php echo esc_attr(get_current_user_id()!= $chat->sender ? $chat->sender_name : __('You', 'disputo')); ?>:
            <?php echo apply_filters('bbpm_excerpt', $chat->excerpt, $chat); ?>
        </p>

        <div class="bbpm-user-meta">
            
            <span class="bbpm-time" title="<?php echo bbpm_date($chat->date); ?>"><?php echo bbpm_time_diff($chat->date, null, null); ?></span>
            <?php if ( in_array('unread', $chat->classes) && (int) $chat->unread_count ) : ?>
                <span class="bbpm-count">+<?php echo $chat->unread_count; ?></span>
            <?php endif; ?>

        </div>

    </div>

    </div>    
        
    <noscript>
        <a href="<?php echo esc_url(bbpm_messages_url($chat->chat_id)); ?>" class="bbpm-read">
            <?php esc_attr_e('View chat', 'disputo'); ?>
        </a>
    </noscript>
</li>
