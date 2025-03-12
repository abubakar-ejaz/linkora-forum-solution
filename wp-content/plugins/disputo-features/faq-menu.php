<?php
$disputo_tax_args = array(
    'orderby'    => 'ID', 
    'order'      => 'ASC',
    'hide_empty' => true
); 
$disputo_categories = get_terms("disputofaqcats", $disputo_tax_args);
$disputo_cat_count = count($disputo_categories);

if ( $disputo_cat_count > 0 ) {
?>
<div class="disputo-faq-menu">      
<ul class="list-group"> 
<?php	
foreach ( $disputo_categories as $cat ) {
    $catid = $cat->term_id;
?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="#" data-cat="disputo-cat-<?php echo esc_html($catid); ?>"><?php echo esc_html($cat->name); ?></a><span class="badge badge-primary badge-pill"><?php disputo_count_faq_in_cat($catid); ?></span>
    </li>   
<?php } ?>
</ul>
</div>    
<?php } ?>