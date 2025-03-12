<div <?php post_class(); ?>>
    <div class="card-masonry">
    <div class="card">
    <?php if (has_post_thumbnail()) { ?>
    <?php
    $disputo_thumb_id = get_post_thumbnail_id();
    $disputo_thumb_url_array = wp_get_attachment_image_src($disputo_thumb_id, 'disputo-thumbnail', true);
    $disputo_thumb_url = $disputo_thumb_url_array[0];
    ?>
    <a class="card-featured-img" href="<?php the_permalink(); ?>">
        <ul class="card-badges">
            <li data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Topics', 'disputo' ); ?>"><span class="badge badge-primary"><i class="fa fa-comment"></i> <?php echo esc_html(bbp_get_forum_topic_count( get_the_id(), true )); ?></span></li>
            <li data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Replies', 'disputo' ); ?>"><span class="badge badge-primary"><i class="fa fa-comments"></i> <?php bbp_show_lead_topic() ? bbp_forum_reply_count(get_the_id()) : bbp_forum_post_count(get_the_id()); ?></span></li>
        </ul>
        <img src="<?php echo esc_url($disputo_thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />   
    </a>    
    <?php } ?>
        <div class="card-body">
            <div class="card-ellipsis"><h3 class="card-title-small"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></div>
            <div class="card-ellipsis"><p><em><?php echo esc_html(bbp_get_forum_content( get_the_id() )); ?></em></p></div>
        </div>
    </div> 
</div>
</div>