<?php

/**
 * Search Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<div class="disputo-forum-search-result">
    <div class="disputo-forum-search-badge">
        <span class="badge badge-success"><?php esc_html_e( 'Reply', 'disputo' ); ?></span>
    </div>
    <?php if (bbp_get_reply_author_link()) { ?>
    <div class="disputo-forum-search-result-left">
        <?php bbp_reply_author_link( array( 'sep' => '', 'show_role' => false, 'type' => 'avatar' ) ); ?>
    </div>
    <?php } ?>
    <div class="disputo-forum-search-result-right">
        <div class="disputo-forum-search-result-meta">
            <span class="bbp-reply-post-date"><?php bbp_reply_post_date(); ?></span>
            <a href="<?php bbp_reply_url(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a>
	   </div>
	   <div class="disputo-forum-search-result-title">
           <h5><?php esc_html_e( 'In reply to: ', 'disputo' ); ?><a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a></h5>
	   </div>
    </div>
</div>