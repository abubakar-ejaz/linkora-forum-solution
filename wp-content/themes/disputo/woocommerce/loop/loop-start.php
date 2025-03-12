<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$disputo_shop_layout = esc_attr(get_theme_mod('disputo_shop_layout', 'twocolumns'));
$disputo_selected_shop_layout = '';
$disputo_small_grid = '';

if ($disputo_shop_layout == 'fourcolumns') { 
    $disputo_selected_shop_layout = 'disputo-four-columns';
} elseif ($disputo_shop_layout == 'threecolumns') { 
    $disputo_selected_shop_layout = 'disputo-three-columns';
} else {
    $disputo_selected_shop_layout = 'disputo-two-columns';
}

if ((is_cart()) || (is_checkout())) {
    $disputo_selected_shop_layout = 'disputo-four-columns';
}

if ($disputo_selected_shop_layout == 'disputo-four-columns') {
    $disputo_small_grid = 'small-grid';
}

?>
<div class="clearfix"></div>
<div class="disputo-masonry-grid <?php echo esc_html($disputo_small_grid); ?>">
<div class="<?php echo esc_attr($disputo_selected_shop_layout); ?>" data-columns>