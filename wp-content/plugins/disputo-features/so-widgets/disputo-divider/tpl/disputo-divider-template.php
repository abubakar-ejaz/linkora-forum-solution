<?php
$divider_fullwidth = '';
if ($instance['fullwidth'] == 'on') {
    $divider_fullwidth = 'fullwidth-divider';
}
?>

<?php echo "<hr class='disputo-divider-widget " . $divider_fullwidth . "' style='border:none;margin-top:" . esc_attr($instance['margintop']) . "px; margin-bottom:" . esc_attr($instance['marginbottom']) . "px; background:" . esc_attr($instance['bgcolor']) . "; height:" . esc_attr($instance['thickness']) . "px;' />"; ?>