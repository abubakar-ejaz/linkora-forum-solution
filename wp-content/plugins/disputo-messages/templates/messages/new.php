<?php global $bbpm_bases, $bbpm_recipient, $bbpm_search, $bbpm_chat_id;

?>

<div class="bbpm-new">
    <?php if ( !empty( $bbpm_recipient->ID ) ) : ?>

        <form method="post" action="<?php echo bbpm_messages_url('send'); ?>">

            <h3><?php printf( __('Send a new message to %s', 'disputo'), $bbpm_recipient->display_name ); ?></h3>

            <p class="form-section<?php echo bbpm_has_errors('message') ? ' has-errors' : ''; ?>">
                <?php echo bbpm_message_field(bbpm_old('message', true)); ?>
                <?php if ( bbpm_has_errors('message') ) : ?>
                    <?php bbpm_print_error( 'message' ); ?>
                <?php endif; ?>
            </p>
            
            <div class="btn-group" role="group">
                <?php wp_nonce_field('send_message', 'bbpm_nonce'); ?>
                <input type="hidden" name="chat_id" value="<?php echo $bbpm_chat_id; ?>" />
                <input class="btn btn-primary" type="submit" name="send_message" value="<?php esc_attr_e('Send', 'disputo'); ?>" />
                <a class="btn btn-danger" href="<?php echo bbpm_messages_url(); ?>"><i class="fa fa-times"></i></a>
            </div>

        </form>

    <?php else : ?>

        <form method="post" action="<?php echo bbpm_messages_url($bbpm_bases['new']); ?>">
            <label><strong><?php _e('Search and select a contact:', 'disputo'); ?></strong></label>
                <div class="input-group" style="margin-bottom:1.5rem;">
                    <input type="text" class="form-control" name="search" value="<?php bbpm_old('search'); ?>" placeholder="<?php esc_attr_e('Search', 'disputo'); ?>" id="search" />
                    <div class="input-group-append"> 
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <?php if ( bbpm_has_errors('search') ) : ?>
                    <?php bbpm_print_error( 'search' ); ?>
                <?php endif; ?>

            <?php if ( isset($bbpm_search) ) { ?>

                <?php if ( $bbpm_search ) : ?>
                    <ul class="bbpm-user-results">
                    <?php foreach ( $bbpm_search as $user ) : ?>

                        <li>
                        <input type="radio" name="u" value="<?php echo $user->ID; ?>" <?php checked(bbpm_old('u',1), $user->ID); ?>/>
                        <?php echo get_avatar($user->ID, 22); ?> <?php echo $user->display_name; ?>
                        </li>

                    <?php endforeach; ?>
                    </ul>
                <?php else : ?>
            <div class="bbp-template-notice">
                    <p><?php _e('No users have matched your search query.', 'disputo'); ?></p>
            </div>
                <?php endif; ?>

            <?php } ?>
            
            <div class="btn-group" role="group">
                <?php wp_nonce_field('bbpm_nonce', 'bbpm_nonce'); ?>
                <input class="btn btn-primary" type="submit" name="select_recipient" value="<?php esc_attr_e('Select recipient', 'disputo'); ?>" />
                <a class="btn btn-danger" href="<?php echo bbpm_messages_url(); ?>"><?php _e('Cancel', 'disputo'); ?></a>
            </div>

        </form>

    <?php endif; ?>
</div>