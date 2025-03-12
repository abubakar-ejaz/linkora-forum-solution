<?php extract(bbpm_prepare_contact_button($user_id)); ?>

<a href="<?php echo esc_url($link); ?>" title="<?php echo $link_title; ?>" class="btn btn-sm btn-primary bbpm-contact-btn">
    <span><?php echo $inner_text; ?></span>
</a>