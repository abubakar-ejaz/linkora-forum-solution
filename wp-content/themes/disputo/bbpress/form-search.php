<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" action="<?php bbp_search_url(); ?>">
	<div class="input-group">
		<input type="hidden" name="action" value="bbp-search-request" />
		<input tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" class="form-control" placeholder="<?php esc_attr_e('Search Forums...', 'disputo'); ?>" />
        <div class="input-group-append"> 
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </div>
	</div>
</form>
