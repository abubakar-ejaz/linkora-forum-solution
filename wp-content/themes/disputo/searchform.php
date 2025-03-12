<?php $disputo_search_exclude_pages = get_theme_mod( 'disputo_search_exclude_pages' ); ?> 
<form role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div class="input-group">
    <input type="text" class="form-control" placeholder="<?php esc_attr_e('Enter a keyword...', 'disputo'); ?>" name="s" />
        <div class="input-group-append"> 
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            <?php if ($disputo_search_exclude_pages) { ?>
                <input type="hidden" name="post_type" value="post" /> 
            <?php } ?>
        </div>
    </div>
</form>