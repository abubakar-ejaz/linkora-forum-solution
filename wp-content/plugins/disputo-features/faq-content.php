<div id="disputo-faq-cat-container" data-children=".mp-accordion-item" class="mp-accordion">
<?php
$disputo_tax_args = array(
    'orderby'    => 'ID', 
    'order'      => 'ASC',
    'hide_empty' => true
);     
$disputo_categories = get_terms("disputofaqcats", $disputo_tax_args);

foreach($disputo_categories as $category) { 
    $catid = $category->term_id;
?>
<?php 
$disputo_faq_args = array(
    'post_type' => 'disputofaq',
    'posts_per_page' => 99,
    'order' => 'ASC',
    'tax_query' => array(
		array(
			'taxonomy' => 'disputofaqcats',
			'field'    => 'slug',
            'terms'    => $category->slug
		),
	),
); 
$disputo_faq_query = new WP_Query( $disputo_faq_args );
$disputo_cat_count = $disputo_faq_query->post_count;  
?>
<h4 id="disputo-cat-<?php echo esc_html($category->term_id); ?>" class="disputo-faq-cat-title"><?php echo esc_html($category->name); ?><span class="badge badge-primary badge-pill"><?php esc_html_e($disputo_cat_count); ?></span></h4>
<div class="disputo-faq-container">    
<?php while($disputo_faq_query->have_posts()) : $disputo_faq_query->the_post(); ?>
<?php $disputo_answer = get_post_meta( get_the_id(), 'disputo_cmb2_answer', true ); ?>
    <div class="disputo-live-search-results mp-accordion-item">
        <a class="mp-accordion-title collapsed" data-toggle="collapse" data-parent="#disputo-faq-cat-container" href="#mp-accordion-item-<?php echo esc_html(get_the_id()); ?>" aria-expanded="false" aria-controls="mp-accordion-item-<?php echo esc_html(get_the_id()); ?>">
            <?php the_title('<strong>', '</strong>'); ?>
        </a>
        <div id="mp-accordion-item-<?php echo esc_html(get_the_id()); ?>" class="collapse" role="tabpanel">
        <div class="mp-accordion-content"><?php echo wp_kses_post(wpautop($disputo_answer)); ?></div>
        </div>
    </div>
<?php endwhile; ?>
</div>  
<?php wp_reset_postdata(); ?>
<?php } ?>
</div>