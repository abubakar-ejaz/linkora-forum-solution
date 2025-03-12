<div class="disputo-tabs">  
<ul class="nav nav-tabs">
    <?php 
if ( ! empty( $instance['a_repeater'] ) ) {
    $tab_items = $instance['a_repeater'];
    $i = 0;
    foreach( $tab_items as $index => $repeater_item ) {
        $tabs_title = $repeater_item['title'];
        $tabs_icon = $repeater_item['icon'];
        if ($i == 0) {
            $tabs_active = 'active';
            $tabs_expanded = 'true';
        } else {
            $tabs_active = '';
            $tabs_expanded = 'false';
        }
        echo '<li class="nav-item"><a class="nav-link ' . $tabs_active . '" data-toggle="tab" href="#mp-tab-' . sanitize_title($tabs_title) . '" aria-expanded="' . $tabs_expanded . '">' . siteorigin_widget_get_icon($tabs_icon) . ' ' . $tabs_title . '</a></li>';
        $i++;
    }
?>
</ul>
<div class="disputo-tabs-content tab-content">
    <?php       
    $count = 0;
    foreach( $tab_items as $index => $repeater_item ) {
        $tabs_title = $repeater_item['title'];
        $tabs_editor = $repeater_item['text'];
        if ($count == 0) {
            $tabs_active = 'active show';
            $tabs_expanded = 'true';
        } else {
            $tabs_active = '';
            $tabs_expanded = 'false';
        }
        echo '<div class="tab-pane fade ' . $tabs_active . '" id="mp-tab-' . sanitize_title($tabs_title) . '" aria-expanded="' . $tabs_expanded . '">' . do_shortcode($tabs_editor) . '</div>';
        $count++;
        }
    }
?>  
</div>
</div>