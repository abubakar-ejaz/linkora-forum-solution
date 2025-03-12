<?php
/* Forum select field */

class disputo_Forum_Select extends SiteOrigin_Widget_Field_Base {   

	protected function render_field( $value, $instance ) {
        $disputo_forum_args = array(
            'post_type' => 'forum',
            'posts_per_page' => 999,
            'order' => 'ASC',
            'orderby' => 'title'
        );
        $disputo_forum_query = new WP_Query( $disputo_forum_args ); ?>
        
        <select id="<?php echo $this->element_id; ?>" name="<?php echo $this->element_name; ?>">
            <option value="0"><?php esc_html_e( 'Forum Index' , 'disputo' ); ?></option>
        <?php while($disputo_forum_query->have_posts()) : $disputo_forum_query->the_post(); ?>     
            <option value="<?php echo get_the_id(); ?>" <?php if ($value == get_the_id()) { echo 'selected'; } ?>><?php the_title(); ?></option>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
        </select>
        <?php
	}

	protected function sanitize_field_input($value, $instance) {
		$sanitized_value = sanitize_text_field( $value );
		return $sanitized_value;
	}

	protected function add_label_classes( $label_classes ) {
		$label_classes[] = 'disputo-forum-select';
		return $label_classes;
	}

	protected function render_field_label($value, $instance) {
		?>
		<label class="siteorigin-widget-field-label"><?php esc_html_e( 'Select Forum' , 'disputo' ); ?></label>
		<?php
	}
	protected function render_before_field( $value, $instance ) {
		// This is to keep the default label rendering behaviour.
		parent::render_before_field( $value, $instance );
		// Add custom rendering here.
		$this->render_field_description();
	}

	protected function render_after_field( $value, $instance ) {
		// Leave this blank so that the description is not rendered twice
	}
}
?>