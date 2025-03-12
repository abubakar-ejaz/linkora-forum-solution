<?php
/*---------------------------------------------------
Ads Manager
----------------------------------------------------*/

function disputo_before_forums_index() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_forums_index') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_forums_index') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_after_forums_index() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_forums_index') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_forums_index') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_before_search() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_search') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_search') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_after_search_results() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_search_results') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_search_results') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_before_single_forum() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_single_forum') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_single_forum') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_after_single_forum() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_single_forum') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_single_forum') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_before_single_topic() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_single_topic') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_single_topic') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_after_single_topic() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_single_topic') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_single_topic') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_before_lead_topic() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_lead_topic') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_before_lead_topic') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_after_lead_topic() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_lead_topic') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'bbp_template_after_lead_topic') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
<?php }
        }
    }
}

function disputo_add_before_footer() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'disputo_before_footer') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="container">
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>
</div>    
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'disputo_before_footer') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="container">
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>
</div>    
<?php }
        }
    }    
}

function disputo_add_before_single_post() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'disputo_before_single_post') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>  
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'disputo_before_single_post') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>   
<?php }
        }
    }    
}

function disputo_add_after_single_post() {
    $disputo_ads_imageads = disputoads_get_option( 'disputo_ads_imageads' );
    $disputo_ads_codeads = disputoads_get_option( 'disputo_ads_codeads' );
    if (!empty($disputo_ads_imageads)) {
        foreach ( (array) $disputo_ads_imageads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_image = $disputo_ads_destination = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'disputo_after_single_post') {
                if ( isset( $entry['disputo_ads_image'] ) ) {            
                    $disputo_ads_image = $entry['disputo_ads_image'];
                }
                if ( isset( $entry['disputo_ads_destination'] ) ) {            
                    $disputo_ads_destination = $entry['disputo_ads_destination'];
                } ?>
<div class="disputo-image-ad <?php echo esc_html($disputo_ads_field); ?>">
    <a href="<?php echo esc_url($disputo_ads_destination); ?>" target="_blank">
        <img src="<?php echo esc_url($disputo_ads_image); ?>" alt="" />
    </a>
</div>  
<?php }
        }
    }
    if (!empty($disputo_ads_codeads)) {
        foreach ( (array) $disputo_ads_codeads as $key => $entry ) { 
            $disputo_ads_field = $disputo_ads_code = '';
            if ( isset( $entry['disputo_ads_field'] ) ) {            
                $disputo_ads_field = $entry['disputo_ads_field'];
            }
            if ($disputo_ads_field == 'disputo_after_single_post') {
                if ( isset( $entry['disputo_ads_code'] ) ) {            
                    $disputo_ads_code = $entry['disputo_ads_code'];
                } ?>
<div class="disputo-code-ad <?php echo esc_html($disputo_ads_field); ?>">
    <?php echo $disputo_ads_code; ?>
</div>  
<?php }
        }
    }     
}

$disputo_ads_enable = disputoads_get_option( 'disputo_ads_enable' );

if ($disputo_ads_enable == 'on') {
    add_action('bbp_template_before_forums_index','disputo_before_forums_index');
    add_action('bbp_template_after_forums_index','disputo_after_forums_index');
    add_action('bbp_template_before_search','disputo_before_search');
    add_action('bbp_template_after_search_results','disputo_after_search_results');
    add_action('bbp_template_before_single_forum','disputo_before_single_forum');
    add_action('bbp_template_after_single_forum','disputo_after_single_forum');
    add_action('bbp_template_before_single_topic','disputo_before_single_topic');
    add_action('bbp_template_after_single_topic','disputo_after_single_topic');
    add_action('bbp_template_before_lead_topic','disputo_before_lead_topic');
    add_action('bbp_template_after_lead_topic','disputo_after_lead_topic');
    add_action('disputo_before_footer','disputo_add_before_footer');
    add_action('disputo_before_single_post','disputo_add_before_single_post');
    add_action('disputo_after_single_post','disputo_add_after_single_post');
}
?>