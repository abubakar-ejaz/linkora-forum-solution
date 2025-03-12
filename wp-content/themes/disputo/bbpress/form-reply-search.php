<?php

/**
 * Search
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( bbp_allow_search() ) : ?>

	<div class="bbp-search-form">
		<form role="search" method="get" id="bbp-topic-search-form">
            <div class="input-group">
            <input type="text" class="form-control" value="<?php bbp_search_terms(); ?>" name="rs" id="rs" placeholder="<?php esc_attr_e( 'Search replies...', 'disputo' ); ?>" />
                <div class="input-group-append"> 
                    <button type="submit" id="bbp_search_submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
	</div>

<?php endif; ?>