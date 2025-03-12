<?php $random = rand(); ?>
<div id="youtube-wrapper-<?php echo esc_attr($random); ?>" style="height:<?php echo esc_js($ytheight); ?>px"></div>
<div class="clear"></div>
<script type="text/javascript">
jQuery(document).ready(function() {
    "use strict";
    jQuery('#youtube-wrapper-<?php echo esc_js($random); ?>').ytv({
        apiKey: '<?php echo esc_js($ytapikey); ?>',
        user: '<?php echo esc_js($ytusername); ?>',
        channelId: '<?php echo esc_js($ytchannelid); ?>',
        browsePlaylists: <?php if (!empty($ytplaylist)) { echo esc_js($ytplaylist); } else { echo 'false'; } ?>,
        maxvideo: <?php if (!empty($ytvideonumber)) { echo esc_js($ytvideonumber); } else { echo '10'; } ?>,
        maxplaylist: <?php if (!empty($ytplaylistnumber)) { echo esc_js($ytplaylistnumber); } else { echo '20'; } ?>,
        controls: true,
        autoplay: false
    });
});     
</script>