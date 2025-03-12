<?php if (post_password_required()) { return; } ?>
<?php if ((have_comments()) || (comments_open())) { ?>
<div id="disputo-comments-wrapper">
<?php if (have_comments()) { ?>
<?php $disputo_num_comments = get_comments_number(); ?>
<div id="disputo_comments_block" class="disputo_comments_block">
    <h3 class="disputo-comments-title"><?php esc_html_e("Comments", 'disputo'); ?></h3>

    <ol class="disputo_commentlist">
        <?php wp_list_comments( array('callback' => 'disputo_comment') ); ?>
    </ol>
    <div class="disputo_comments_rss">
        <?php post_comments_feed_link('<i class="fa fa-rss-square"></i>' . esc_html__( 'Subscribe', 'disputo' )); ?>
    </div>  
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
    <div class="disputo-pager comments-pager">    
            <div class="disputo-pager-left">
                <?php previous_comments_link( '<i class="fa fa-chevron-left"></i> ' . esc_html__( 'Older comments', 'disputo' ) ); ?>
            </div>
            <div class="disputo-pager-right">
                <?php next_comments_link( esc_html__( 'Newer comments', 'disputo' ) .  ' <i class="fa fa-chevron-right"></i>'); ?>
            </div>
        <div class="clearfix"></div>
        </div>
    <?php } ?>

<?php
if (!empty($comments_by_type['pings'])) {
    $disputo_count = count($comments_by_type['pings']);
    ($disputo_count !== 1) ? $disputo_txt = esc_html__('Pings&#47;Trackbacks', 'disputo') : $disputo_txt = esc_html__('Pings&#47;Trackbacks', 'disputo');
?>

    <h6 id="pings"><?php printf( esc_html__( '%1$d %2$s for "%3$s"', 'disputo'), $disputo_count, $disputo_txt, get_the_title() )?></h6>

    <ol class="disputo_commentlist">
        <?php wp_list_comments('type=pings&max_depth=<em>'); ?>
    </ol>

<?php } ?>
</div>     
<?php } ?>     
<?php if (comments_open()) { ?>  
<div id="disputo_comment_form" class="disputo_comment_form">   
    <?php
    $comments_args = array(
        'title_reply_before'=>'<h3>',
        'title_reply_after'=>'</h3>',
        'cancel_reply_before' => '<span class="disputo_cancel">',
        'cancel_reply_after' => '</span>',
        'class_submit' => 'btn btn-primary'
    );
    ?>
    <?php comment_form($comments_args); ?>
</div>    
<?php } ?>
</div>    
<?php } ?>