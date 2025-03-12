<?php global $bbpm_inbox_ids, $bbpm_pagination, $bbpm_bases, $bbpm_chat_id, $bbpm_message, $bbpm_recipient, $bbpm_chat;

?>

<?php do_action('bbpm_single_before_content'); ?>

<div class="bbpm-messages bbpm-items <?php echo implode(' ', apply_filters('bbpm_single_chat_classes', array())); ?>">

    <div class="bbpm-head">           
            <h3><?php echo esc_attr($bbpm_chat->name); ?></h3>
        
            <div class="bbpm-chat-links">

            <?php do_action('bbpm_single_chat_links'); ?>

            <a href="<?php echo bbpm_messages_url(); ?>" class="btn btn-sm btn-primary"><?php _e('&laquo; Back to chats', 'disputo'); ?></a>

            <?php do_action('bbpm_single_chat_options_link'); ?>

            <a href="<?php echo bbpm_messages_url(sprintf('%s/%s/', $bbpm_chat_id, $bbpm_bases['settings_base'])); ?>" class="btn btn-sm btn-primary"><?php _e('Chat Options', 'disputo'); ?></a>

            <?php do_action('bbpm_single_after_links'); ?>
            </div>
        

        <?php do_action('bbpm_single_before_search'); ?>

        <form class="bbpm-search-form" method="get" action="<?php echo bbpm_messages_url($bbpm_chat_id); ?>">
            <div class="input-group">
                <input class="form-control" type="text" name="search" value="<?php echo esc_attr(bbpm_search_query()); ?>" placeholder="<?php esc_attr_e('Search', 'disputo'); ?>" />
                <div class="input-group-append">    
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <?php do_action('bbpm_single_after_search'); ?>
    </div>

    <div class="bbpm-body">

        <?php do_action('bbpm_single_before_body'); ?>

        <?php if ( bbpm_search_query() ) : ?>
            <p><strong><?php printf(__('Showing search results for "%s":', 'disputo'), bbpm_search_query()); ?></strong></p>
        <?php endif; ?>
        
        <form action="<?php echo bbpm_messages_url(sprintf('%s/actions/', $bbpm_chat_id)); ?>" method="post">

            <?php if ( $bbpm_inbox_ids ) : ?>
    
                <?php do_action('bbpm_single_before_list'); ?>

                <ul class="bbpm-list">
                    
                    <?php foreach ( $bbpm_inbox_ids as $bbpm_message ) : ?>

                        <?php bbpm_load_template('messages/loop-message.php'); ?>

                    <?php endforeach; ?>

                </ul>

                <?php do_action('bbpm_single_after_list'); ?>

                <div class="bbpm-actions-cont">

                    <div class="bbpm-actions">
                        <?php wp_nonce_field("single_actions_{$bbpm_chat_id}", 'bbpm_nonce'); ?>

                        <?php do_action('bbpm_single_before_actions_menu_2'); ?>
                        <div class="input-group">
                        <select name="action">
                            <option value=""><?php _e('Bulk Actions', 'disputo'); ?></option>
                            <option value="delete"><?php _e('Delete', 'disputo'); ?></option>
                            <?php do_action('bbpm_messages_bulk_actions'); ?>
                        </select>

                        <?php do_action('bbpm_single_before_actions_submit'); ?>
                        <div class="input-group-append">   
                            <button type="submit" name="apply" class="btn btn-primary"><i class="fa fa-check"></i></button>
                        </div>
                        </div>

                        <?php do_action('bbpm_single_after_actions_submit'); ?>
                    </div>

                    <?php do_action('bbpm_single_after_actions'); ?>
                </div>

                <?php if ( !empty($bbpm_chat->seen) ) : ?>

                    <?php do_action('bbpm_single_before_chat_read_receipts'); ?>
                
                    <p class="bbpm-read-receipts">
                        <?php _ex('&check; Seen', 'message read receipts', 'disputo'); ?>
                        <?php foreach ( $bbpm_chat->seen as $user ) : ?>
                            <span title="<?php printf(__('Seen by %s', 'disputo'), $user->display_name); ?>">
                                <?php echo get_avatar($user->ID, 15); ?>
                            </span>
                        <?php endforeach; ?>
                    </p>

                    <?php do_action('bbpm_single_after_chat_read_receipts'); ?>
                
                <?php else : ?>
                    
                    <p class="bbpm-read-receipts"></p>

                <?php endif; ?>

            <?php elseif ( bbpm_search_query() ) : ?>

                <?php do_action('bbpm_single_search_no_results'); ?>
                <div class="bbp-template-notice error">
                <p class="bbpm-no-items"><?php _e('No messages have matched your search query, please try again with a different search term', 'disputo'); ?></p>
                </div>    
            <?php else : ?>

                <?php do_action('bbpm_single_empty_chat'); ?>
                <div class="bbp-template-notice">
                <p class="bbpm-empty-chat"><?php _e('There are no messages to show.', 'disputo'); ?></p>
                </div>
            <?php endif; ?>

        </form>

        <?php do_action('bbpm_single_after'); ?>

    </div>

    <div class="bbpm-foot">

        <?php do_action('bbpm_single_before_footer_contents'); ?>

        <?php if ( empty($bbpm_recipient->ID) || bbpm_can_contact($bbpm_recipient->ID) ) : ?>

            <form method="post" action="<?php echo bbpm_messages_url('send'); ?>">
                <?php do_action('bbpm_single_before_form_contents'); ?>

                <p>
                    <?php echo bbpm_message_field(); ?>
                </p>

                <?php do_action('bbpm_single_after_form_message_field'); ?>

                <p>
                    <?php wp_nonce_field('send_message', 'bbpm_nonce'); ?>

                    <input type="hidden" name="chat_id" value="<?php echo $bbpm_chat_id; ?>" />
                    
                    <?php do_action('bbpm_single_before_form_submit'); ?>

                    <input type="submit" name="send_message" value="<?php esc_attr_e('Send', 'disputo'); ?>" />

                    <?php do_action('bbpm_single_after_form_submit'); ?>
                </p>

                <?php do_action('bbpm_single_after_form_contents'); ?>
            </form>

        <?php endif; ?>

        <div class="bbpm-pagi">
            <?php do_action('bbpm_single_before_pagi_links'); ?>

            <?php echo paginate_links($bbpm_pagination); ?>
        
            <?php do_action('bbpm_single_after_pagi_links'); ?>
        </div>

        <?php do_action('bbpm_single_after_footer_contents'); ?>

    </div>

</div>

<?php do_action('bbpm_single_after_content'); ?>