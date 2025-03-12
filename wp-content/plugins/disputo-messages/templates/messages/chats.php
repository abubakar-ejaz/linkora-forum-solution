<?php global $bbpm_chats, $bbpm_pagination, $bbpm_bases;

?>
<?php do_action('bbpm_chats_before_content'); ?>

<h2 class="entry-title"><?php esc_html_e( 'Messages', 'disputo' ); ?></h2>

<div class="bbpm-chats bbpm-items">

    <div class="bbpm-head">

        <?php do_action('bbpm_chats_before_header_content'); ?>

        <div class="bbpm-navlinks">
            <?php do_action('bbpm_chats_header_before_nav_links'); ?>

            <a href="<?php echo bbpm_messages_url($bbpm_bases['new']); ?>" class="btn btn-info"><?php _e('New Message', 'disputo'); ?> <i class="fa fa-plus"></i></a>

            <?php do_action('bbpm_chats_header_nav_links'); ?>
        </div>
        
        <?php do_action('bbpm_chats_header_before_search_form'); ?>

        <form class="bbpm-search-form" method="get" action="<?php echo bbpm_messages_url(); ?>">
            <div class="input-group">
            <input type="text" class="form-control" name="search" value="<?php echo esc_attr(bbpm_search_query()); ?>" placeholder="<?php esc_attr_e('Search', 'disputo'); ?>" />
                <div class="input-group-append"> 
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <?php do_action('bbpm_chats_after_header_content'); ?>

    </div>

    <div class="bbpm-body">

        <?php if ( bbpm_search_query() ) : ?>
        <div class="bbp-template-notice">
            <p><?php printf(__('Showing search results for "%s":', 'disputo'), bbpm_search_query()); ?></p>
        </div>
        <?php endif; ?>

        <?php if ( $bbpm_chats->hasChats() ) : ?>

            <ul class="bbpm-list">
                
                <?php while ( $bbpm_chats->hasChats(true) ) : $bbpm_chats->theChat(); ?>

                    <?php bbpm_load_template('messages/loop-chat.php'); ?>

                <?php endwhile; ?>

            </ul>

        <?php elseif ( bbpm_search_query() ) : ?>
        <div class="bbp-template-notice">
            <p class="bbpm-no-items"><?php _e('No chats have matched your search query, please try again with a different search term', 'disputo'); ?></p>
        </div>
        <?php else : ?>
        <div class="bbp-template-notice">
            <p class="bbpm-no-chats"><?php printf(__('There are no chats to show. Get started by <a href="%s">sending a message &raquo;</a>', 'disputo'), bbpm_messages_url($bbpm_bases['new'])); ?></p>
        </div>
        <?php endif; ?>

    </div>

    <div class="bbpm-foot">

        <div class="bbpm-pagi">
            <?php echo paginate_links($bbpm_pagination); ?>
        </div>

    </div>

</div>

<?php do_action('bbpm_chats_after_content'); ?>