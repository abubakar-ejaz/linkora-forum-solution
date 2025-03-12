<?php $disputo_post_type = get_post_type(get_the_id()); ?>
<div <?php post_class(); ?>>
    <div class="card-masonry card-small">
    <div class="card">
    <?php if (has_post_thumbnail()) { ?>
    <?php
    $disputo_thumb_id = get_post_thumbnail_id();
    $disputo_thumb_url_array = wp_get_attachment_image_src($disputo_thumb_id, 'disputo-thumbnail', true);
    $disputo_thumb_url = $disputo_thumb_url_array[0];
    ?>
    <a class="card-featured-img" href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_url($disputo_thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />   
    </a>    
    <?php } ?>
        <div class="card-body">
            <?php if ($disputo_post_type == "post") { ?>
            <?php $disputo_num_comments = get_comments_number(); ?>
            <a class="disputo-masonry-post-date" href="<?php the_permalink(); ?>"><?php the_time(get_option('date_format')); ?></a>
            <?php } ?>
            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        </div>
        <?php if ($disputo_post_type == "post") { ?>
        <div class="card-footer">
            <div>
            <a class="disputo-post-author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?> <?php the_author(); ?></a>
            </div>
            <?php $disputo_num_comments = get_comments_number(); ?>
            <div class="disputo-comment-count">
                <i class="fa fa-comments"></i><span><?php echo esc_html($disputo_num_comments); ?></span>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php } ?>
    </div> 
</div>
</div>