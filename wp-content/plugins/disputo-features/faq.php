<?php
function register_disputo_faq_posttype() {
    $labels = array(
        'name'              => esc_attr__( 'FAQ', 'disputo' ),
        'singular_name'     => esc_attr__( 'Question', 'disputo' ),
        'add_new'           => esc_attr__( 'Add new question', 'disputo' ),
        'add_new_item'      => esc_attr__( 'Add new question', 'disputo' ),
        'edit_item'         => esc_attr__( 'Edit question', 'disputo' ),
        'new_item'          => esc_attr__( 'New question', 'disputo' ),
        'view_item'         => esc_attr__( 'View question', 'disputo' ),
        'search_items'      => esc_attr__( 'Search questions', 'disputo' ),
        'not_found'         => esc_attr__( 'No question found', 'disputo' ),
        'not_found_in_trash'=> esc_attr__( 'No question found in trash', 'disputo' ),
        'parent_item_colon' => esc_attr__( 'Parent question:', 'disputo' ),
        'menu_name'         => esc_attr__( 'FAQ', 'disputo' )
    );

    $taxonomies = array();
 
    $supports = array('title');
 
    $post_type_args = array(
        'labels'            => $labels,
        'singular_label'    => esc_attr__('FAQ', 'disputo'),
        'public'            => false,
        'exclude_from_search' => true,
        'show_ui'           => true,
        'show_in_nav_menus' => true,
        'publicly_queryable'=> true,
        'query_var'         => true,
        'capability_type'   => 'post',
        'has_archive'       => false,
        'hierarchical'      => false,
        'rewrite'           => array( 'slug' => 'faq', 'with_front' => false ),
        'supports'          => $supports,
        'menu_position'     => 99,
        'menu_icon'         => 'dashicons-sos',
        'taxonomies'        => $taxonomies
    );
    register_post_type('disputofaq',$post_type_args);
}
add_action('init', 'register_disputo_faq_posttype');

// Register taxonomy

function disputo_faq_taxonomy() {
    register_taxonomy(
        'disputofaqcats',
        'disputofaq',
        array(
            'labels' => array(
                'name' => esc_attr__( 'FAQ Categories', 'disputo' ),
                'add_new_item' => esc_attr__( 'Add new category', 'disputo' ),
                'new_item_name' => esc_attr__( 'New category', 'disputo' )
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true
        )
    );
}
add_action( 'init', 'disputo_faq_taxonomy', 0 );

// Answer

function disputo_answer( $meta_boxes ) {
    $prefix = 'disputo_cmb2'; // Prefix for all fields
    $meta_boxes['disputo_answer'] = array(
        'id' => 'disputo_answer',
        'title' => esc_attr__( 'Answer', 'disputo'),
        'object_types' => array('disputofaq'), // post type
        'context' => 'normal',
        'priority' => 'default',
        'show_names' => false, // Show field names on the left
        'fields' => array(
            array(
                'name'    => $prefix . '_answer',
                'id'      => $prefix . '_answer',
                'type'    => 'wysiwyg',
                'options' => array(
                    'wpautop' => true,
                    'media_buttons' => true,
                    'teeny' => true
                ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'disputo_answer' );
?>