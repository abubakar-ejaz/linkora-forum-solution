<?php
/* ----------------------------------------------------------
Add Widget Collection
------------------------------------------------------------- */
function add_disputo_widgets_collection($folders){
	$folders[] = plugin_dir_path(__FILE__).'so-widgets/';
	return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'add_disputo_widgets_collection');

/* ----------------------------------------------------------
Activate Widgets
------------------------------------------------------------- */
function disputo_filter_active_widgets($active){
    $active['disputo-forums'] = true;
    $active['disputo-topics'] = true;
    $active['disputo-populartopics'] = true;
    $active['disputo-reply'] = true;
    $active['disputo-slider'] = true;
    $active['disputo-carousel'] = true;
    $active['disputo-accordion'] = true;
    $active['disputo-tabs'] = true;
    $active['disputo-divider'] = true;
    $active['disputo-masonry'] = true;
    $active['disputo-list'] = true;
    $active['disputo-statistic'] = true;
    $active['disputo-action'] = true;
    $active['disputo-users'] = true;
    $active['disputo-ytv'] = true;
    return $active;
}
add_filter('siteorigin_widgets_active_widgets', 'disputo_filter_active_widgets');

/* ----------------------------------------------------------
Widget Groups
------------------------------------------------------------- */
function disputo_add_widget_tabs($tabs) {
    $tabs[] = array(
        'title' => esc_html__('Disputo Widgets', 'disputo'),
        'filter' => array(
            'groups' => array('disputo')
        )
    );
    return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'disputo_add_widget_tabs', 20);

/* ----------------------------------------------------------
Custom Class Prefix
------------------------------------------------------------- */
function disputo_fields_class_prefixes( $class_prefixes ) {
    $class_prefixes[] = 'disputo_';
    return $class_prefixes;
}
add_filter( 'siteorigin_widgets_field_class_prefixes', 'disputo_fields_class_prefixes' );

/* ----------------------------------------------------------
Add Custom Widget Field
------------------------------------------------------------- */
function disputo_widget_style_fields($fields) {
    $fields['mpaddborder'] = array(
        'name'        => esc_html__('Add Border', 'disputo'),
        'type'        => 'checkbox',
        'group'       => 'design',
        'description' => esc_html__('Add border to the widget.', 'disputo'),
        'priority'    => 4,
    );
    $fields['mpaddshadow'] = array(
      'name'        => esc_html__('Add Shadow', 'disputo'),
      'type'        => 'checkbox',
      'group'       => 'design',
      'description' => esc_html__('Add shadow to the row.', 'disputo'),
      'priority'    => 4,
  );
  return $fields;
}

add_filter( 'siteorigin_panels_widget_style_fields', 'disputo_widget_style_fields' );

function disputo_widget_style_attributes( $attributes, $args ) {
    if( !empty( $args['mpaddborder'] ) ) {
        array_push($attributes['class'], 'disputo-add-border');
    }
    if( !empty( $args['mpaddshadow'] ) ) {
        array_push($attributes['class'], 'disputo-add-shadow');
    }
    return $attributes;
}

add_filter('siteorigin_panels_widget_style_attributes', 'disputo_widget_style_attributes', 10, 2);

/* ----------------------------------------------------------
Add Custom Row Field
------------------------------------------------------------- */
function disputo_row_style_fields($fields) {
    $fields['mpaddshadow'] = array(
        'name'        => esc_html__('Add Shadow', 'disputo'),
        'type'        => 'checkbox',
        'group'       => 'design',
        'description' => esc_html__('Add shadow to the row.', 'disputo'),
        'priority'    => 4,
    );
    $fields['mpstretched'] = array(
        'name'        => esc_html__('Stretched Row', 'disputo'),
        'type'        => 'checkbox',
        'group'       => 'design',
        'description' => esc_html__('Suitable for full width rows.', 'disputo'),
        'priority'    => 4,
    );
    return $fields;
}

add_filter( 'siteorigin_panels_row_style_fields', 'disputo_row_style_fields' );

function disputo_row_style_attributes( $attributes, $args ) {
    if( !empty( $args['mpaddshadow'] ) ) {
        array_push($attributes['class'], 'disputo-add-shadow');
    }
    if( !empty( $args['mpstretched'] ) ) {
        array_push($attributes['class'], 'disputo-stretched');
    }
    return $attributes;
}

add_filter('siteorigin_panels_row_style_attributes', 'disputo_row_style_attributes', 10, 2);

/* ----------------------------------------------------------
Custom Class Path
------------------------------------------------------------- */
function disputo_fields_class_paths( $class_paths ) {
    $class_paths[] = plugin_dir_path( __FILE__ ) . 'so-custom-fields/';
    return $class_paths;
}
add_filter( 'siteorigin_widgets_field_class_paths', 'disputo_fields_class_paths' );
?>