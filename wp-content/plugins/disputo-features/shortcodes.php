<?php
add_shortcode('mpbutton', 'mpbutton');
add_shortcode('mpalert', 'mpalert');
add_shortcode('mprogress', 'mprogress');
add_shortcode('disputoforum', 'disputoforum');
add_shortcode('bquote', 'bquote');

add_filter("the_content", "disputo_content_filter");
add_filter("widget_text", "do_shortcode");
add_filter("widget_text", "disputo_content_filter", 9);

function disputo_content_filter($content) {
 
	// array of custom shortcodes requiring the fix 
	$block = join("|",array("contact-form-7","mpbutton","mpalert","mprogress","mpaccordion","mpaccordioncontainer","disputoforum"));
 
	// opening tag
	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		
	// closing tag
	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
 
	return $rep;
 
}

// Blockquote
function bquote($atts, $content = null) {
    return '<blockquote class="disputo-quote">' . $content . '</blockquote>';
}

// Forum
function disputoforum($atts, $content = null) {
	extract(shortcode_atts(array(
        "forumid" => 'forumid',
        "maxtopics" => 'maxtopics',
        "headinglevel" => 'headinglevel',
        "heading" => 'heading'
	), $atts));
    ob_start();
    include('forum.php');  
    $content = ob_get_contents();
	ob_end_clean();	
	return $content;
}


// Progress
function mprogress($atts, $content = null) {
	extract(shortcode_atts(array(
        "style" => 'style',
        "value" => 'value',
        "label" => 'label',
        "striped" => 'striped',
        "animated" => 'animated'
	), $atts));   
    if (empty($striped)) {
        return '<div class="progress"><div class="progress-bar bg-' . esc_html($style) . '" style="width: ' . esc_html($value) . '%" role="progressbar" aria-valuenow="' . esc_html($value) . '" aria-valuemin="0" aria-valuemax="100">' . esc_html($label) . ' ' . esc_html($value) . '%</div></div>';
    } else {
        if (empty($animated)) {
            return '<div class="progress"><div class="progress-bar progress-bar-striped bg-' . esc_html($style) . '" style="width: ' . esc_html($value) . '%" role="progressbar" aria-valuenow="' . esc_html($value) . '" aria-valuemin="0" aria-valuemax="100">' . esc_html($label) . ' ' . esc_html($value) . '%</div></div>';
        } else {
            return '<div class="progress"><div class="progress-bar progress-bar-striped bg-' . esc_html($style) . ' progress-bar-animated" style="width: ' . esc_html($value) . '%" role="progressbar" aria-valuenow="' . esc_html($value) . '" aria-valuemin="0" aria-valuemax="100">' . esc_html($label) . ' ' . esc_html($value) . '%</div></div>';
        }
    }
}

// Alert
function mpalert($atts, $content = null) {
	extract(shortcode_atts(array(
        "style" => 'style',
        "dismissible" => 'dismissible'
	), $atts));   
    if (empty($dismissible)) {
        return '<div class="alert alert-' . esc_html($style) . '">' . wp_kses_post($content) . '</div>';
    } else {
        return '<div class="alert alert-' . esc_html($style) . '"><div class="close" data-dismiss="alert">&times;</div>' . wp_kses_post($content) . '</div>';
    }
}

// Button
function mpbutton($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => 'url',
        "newtab" => 'newtab',
        "style" => 'style',
        "outline" => 'outline',
        "size" => 'size'
	), $atts));
    if ($newtab != 'yes') {
        if (empty($outline)) {
            return '<a href="' . esc_url($url) . '" class="btn btn-' . esc_html($style) . ' ' . esc_html($size) . '">' . esc_html($content) . '</a>';
        } else {
            return '<a href="' . esc_url($url) . '" class="btn btn-outline-' . esc_html($style) . ' ' . esc_html($size) . '">' . esc_html($content) . '</a>';
        }
    }
    else
    {
        if (empty($outline)) {
            return '<a href="' . esc_url($url) . '" target="_blank" class="btn btn-' . esc_html($style) . ' ' . esc_html($size) . '">' . esc_html($content) . '</a>';
        } else {
            return '<a href="' . esc_url($url) . '" target="_blank" class="btn btn-outline-' . esc_html($style) . ' ' . esc_html($size) . '">' . esc_html($content) . '</a>';
        }
    }
}

// YouTube TV
class disputo_ytv_shortcode {
	static $add_script;

	static function init() {
		add_shortcode('disputoytv', array(__CLASS__, 'handle_shortcode'));
		add_action('wp_footer', array(__CLASS__, 'print_script'));
	}

	static function handle_shortcode($atts) {
		self::$add_script = true;
        extract(shortcode_atts(array(
            "ytapikey" => 'ytapikey',
            "ytusername" => 'ytusername',
            "ytchannelid" => 'ytchannelid',
            "ytvideonumber" => 'ytvideonumber',
            "ytplaylist" => 'ytplaylist',
            "ytplaylistnumber" => 'ytplaylistnumber',
            "ytheight" => 'ytheight'
	   ), $atts));
        ob_start();
        include('ytv.php');
        $content = ob_get_clean();
        return $content;
	}

	static function print_script() {
		if ( ! self::$add_script ) {
			return;
        }
        wp_enqueue_style('disputoytv');
		wp_enqueue_script('disputoytv');
	}
}

disputo_ytv_shortcode::init();
?>