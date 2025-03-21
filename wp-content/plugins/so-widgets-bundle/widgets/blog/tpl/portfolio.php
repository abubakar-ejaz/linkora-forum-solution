<?php
$types = null;

if ( $settings['categories'] || $template_settings['filter_categories'] ) {
	$terms = SiteOrigin_Widget_Blog_Widget::get_query_terms( $instance, $query, get_the_ID() );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$filtering_links = array();

		foreach ( $terms as $term ) {
			$filtering_links[] = sanitize_html_class(
				is_object( $term ) ? $term->slug : $term
			);
		}
		$filtering = join( ', ', $filtering_links );
		$types = $filtering ? join( ' ', $filtering_links ) : ' ';
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'sow-portfolio-item ' . $types ); ?>>
	<div class="sow-entry-thumbnail">
		<a href="<?php the_permalink(); ?>" class="sow-entry-link-overlay">&nbsp;</a>
		<span class="sow-entry-overlay">&nbsp;</span>
		<div class="sow-entry-content">
			<?php
			$tag = siteorigin_widget_valid_tag(
				$settings['tag'],
				'h2'
			);

			the_title(
				'<' . $tag . ' class="sow-entry-title" style="margin: 0 0 5px;">',
				'</' . $tag . '>'
			);

			if ( $settings['categories'] ) {
				?>
				<div class="sow-entry-divider"></div>
				<span class="sow-entry-project-type"><?php echo esc_html( $filtering ); ?></span>
			<?php } ?>
		</div>
		<?php
		if ( ! has_post_thumbnail() ) {
			echo apply_filters( 'siteorigin_widgets_blog_featured_image_fallback', false, $settings );
		} else {
			if ( ! empty( $settings['featured_image_size'] ) ) {
				$size = $settings['featured_image_size'] == 'custom_size' ? array( $settings['featured_image_size_width'], $settings['featured_image_size_height'] ) : $settings['featured_image_size'];
			} else {
				$size = 'sow-blog-portfolio';
			}
			the_post_thumbnail( $size );
		}
		?>
	</div>
</article>
