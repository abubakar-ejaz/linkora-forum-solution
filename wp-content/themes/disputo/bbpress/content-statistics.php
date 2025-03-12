<?php

/**
 * Statistics Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

// Get the statistics
$stats = bbp_get_statistics(); ?>

<div class="disputo-statistics-widget">
    <?php do_action( 'bbp_before_statistics' ); ?>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Registered Users', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['user_count'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-user"></i>
            </div>
        </div>
    </div>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Forums', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['forum_count'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-users"></i>
            </div>
        </div>
    </div>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Topics', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['topic_count'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-comments"></i>
            </div>
        </div>
    </div>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Replies', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['reply_count'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-reply"></i>
            </div>
        </div>
    </div>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Topic Tags', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['topic_tag_count'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-tags"></i>
            </div>
        </div>
    </div>
    <?php if ( !empty( $stats['empty_topic_tag_count'] ) ) : ?>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Empty Topic Tags', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['empty_topic_tag_count'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon light-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-tags"></i>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if ( !empty( $stats['topic_count_hidden'] ) ) : ?>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Hidden Topics', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['topic_count_hidden'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon light-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-comments"></i>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if ( !empty( $stats['reply_count_hidden'] ) ) : ?>
    <div class="disputo-statistics-wrapper">
        <div class="disputo-statistics">
            <small><?php esc_html_e( 'Hidden Replies', 'disputo' ); ?></small>
            <strong><?php echo esc_html( $stats['reply_count_hidden'] ); ?></strong>
        </div>
        <div class="disputo-statistics-icon light-statistics-icon">
            <div class="disputo-statistics-icon-circle">
                <i class="fa fa-reply"></i>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php do_action( 'bbp_after_statistics' ); ?>
</div>

<?php unset( $stats ); ?>