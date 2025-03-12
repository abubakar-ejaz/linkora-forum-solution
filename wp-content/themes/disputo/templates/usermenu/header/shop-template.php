<?php if ( class_exists( 'woocommerce' ) ) { ?>
<a class="dropdown-item" href="<?php echo esc_url(wc_get_page_permalink( 'myaccount' )); ?>"><?php esc_html_e( 'Shop Account', 'disputo' ); ?></a>
<?php } ?>