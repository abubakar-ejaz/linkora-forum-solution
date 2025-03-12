<?php extract(bbpm_prepare_contact_button($user_id)); ?>

<a href="<?php echo esc_url($link); ?>" title="<?php echo $link_title; ?>" class="btn btn-primary bbpm-contact-btn">
    <span><i class="fa fa-paper-plane mr-1"></i><?php echo $inner_text; ?></span>
</a>