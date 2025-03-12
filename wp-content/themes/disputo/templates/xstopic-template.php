<div <?php post_class(); ?>>
    <div class="card-masonry card-small">
    <div class="card">
        <div class="card-body">
            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        </div>
        <div class="card-footer card-forum-meta">
            <div>
            <i class="fa fa-users"></i> <?php echo esc_html(bbp_get_topic_voice_count( get_the_id(), true )); ?>
            </div> 
            <div>
            <i class="fa fa-comments"></i> <?php echo esc_html(bbp_get_topic_reply_count( get_the_id(), true )); ?>
            </div> 
        <div class="clearfix"></div>
        </div>
    </div> 
</div>
</div>