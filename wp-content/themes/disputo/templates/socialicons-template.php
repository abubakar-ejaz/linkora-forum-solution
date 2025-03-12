<?php
$disputosocialicons = '';
if ( function_exists( 'disputosocial_get_option' ) ) {
    $disputosocialicons = disputosocial_get_option( 'disputosocialicons' );
    $disputonewtab = disputosocial_get_option( 'disputosocialiconstab' );
?>           
<ul class="disputo-social-icons">
<?php if (!empty($disputosocialicons)) { ?>    
<?php 
    foreach ( (array) $disputosocialicons as $key => $entry ) { 
    $disputoiconimg = $disputoicontooltip = $disputoiconlink  = '';
    if ( isset( $entry['disputoiconimg'] ) ) {            
        $disputoiconimg = $entry['disputoiconimg'];
    }
    if ( isset( $entry['disputoicontooltip'] ) ) {            
        $disputoicontooltip = $entry['disputoicontooltip'];
    } 
    if ( isset( $entry['disputoiconlink'] ) ) {            
        $disputoiconlink = $entry['disputoiconlink'];
    } 
?>
<?php if (!empty($disputoicontooltip)) { ?>    
    <li data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($disputoicontooltip); ?>"><a href="<?php echo esc_url($disputoiconlink); ?>" <?php if ($disputonewtab == 'on') { echo 'target="_blank"'; } ?>><i class="fa fa-<?php echo esc_attr($disputoiconimg); ?>"></i></a></li>
<?php } else { ?>
    <li><a href="<?php echo esc_url($disputoiconlink); ?>" <?php if ($disputonewtab == 'on') { echo 'target="_blank"'; } ?>><i class="fa fa-<?php echo esc_attr($disputoiconimg); ?>"></i></a></li>
<?php } ?>    
<?php } ?>
<?php } ?>
    <li data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Go to Top', 'disputo' ); ?>"><a id="disputo-go-to-top" href="#"><i class="fa fa-arrow-up"></i></a></li>
</ul>
<?php } ?>