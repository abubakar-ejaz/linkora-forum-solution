<?php
if ( ! empty( $instance['a_repeater'] ) ) {
    $accordion_items = $instance['a_repeater'];
    $main_random = rand();
?>
<div id="mp-accordion-<?php echo esc_html($main_random); ?>" data-children=".mp-accordion-item" class="mp-accordion">
<?php foreach( $accordion_items as $index => $repeater_item ) {
    $random = rand();
    $accordion_title = $accordion_icon = $accordion_editor = $accordion_status = '';
    if ( isset( $repeater_item['title'] ) ) {            
        $accordion_title = $repeater_item['title'];
    }
    if ( isset( $repeater_item['icon'] ) ) {            
        $accordion_icon = $repeater_item['icon'];
    } 
    if ( isset( $repeater_item['text'] ) ) {            
        $accordion_editor = $repeater_item['text'];
    }
    if ( isset( $repeater_item['status'] ) ) { 
        if ($repeater_item['status'] == 'on') {
            $accordion_status = 'show';
        }
    }
    ?>    
  <div class="mp-accordion-item">
    <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#mp-accordion-<?php echo esc_html($main_random); ?>" href="#mp-accordion-item-<?php echo esc_html($random); ?>" aria-expanded="false" aria-controls="mp-accordion-item-<?php echo esc_html($random); ?>">
    <?php echo siteorigin_widget_get_icon($accordion_icon) . esc_html($accordion_title); ?>
    </a>
    <div id="mp-accordion-item-<?php echo esc_html($random); ?>" class="collapse <?php echo $accordion_status; ?>" role="tabpanel">
      <div class="mp-accordion-content"><?php echo do_shortcode($accordion_editor); ?></div>
    </div>
  </div>
<?php } ?>
</div>
<?php } ?>