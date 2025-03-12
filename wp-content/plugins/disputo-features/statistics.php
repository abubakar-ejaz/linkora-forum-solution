<?php
// Post Count
function disputo_post_count() {
    echo esc_html(wp_count_posts()->publish);
}

// Comment Count
function disputo_comment_count() {
    echo esc_html(wp_count_comments()->approved);
}

// Like Count
function disputo_like_count() {
    if ( function_exists( 'disputo_get_like_count' ) ) {
        echo esc_html(disputo_get_like_count());
    }
    else {
        echo '0';
    }
}

// Dislike Count
function disputo_dislike_count() {
    if ( function_exists( 'disputo_get_dislike_count' ) ) {
        echo esc_html(disputo_get_dislike_count());
    }
    else {
        echo '0';
    }
}

// Product Count
function disputo_product_count() {
    echo esc_html(wp_count_posts('product')->publish);
}

// BbPress Registered Users
function disputo_bbpress_user_count() {
    $stats = bbp_get_statistics();
    if ( function_exists( 'bbp_get_statistics' ) ) {
        echo esc_html( $stats['user_count'] );
    } else {
        echo '0';
    }
}

// BbPress Forum Count
function disputo_bbpress_forum_count() {
    $stats = bbp_get_statistics();
    if ( function_exists( 'bbp_get_statistics' ) ) {
        echo esc_html( $stats['forum_count'] );
    } else {
        echo '0';
    }
}

// BbPress Topic Count
function disputo_bbpress_topic_count() {
    $stats = bbp_get_statistics();
    if ( function_exists( 'bbp_get_statistics' ) ) {
        echo esc_html( $stats['topic_count'] );
    } else {
        echo '0';
    }
}

// BbPress Reply Count
function disputo_bbpress_reply_count() {
    $stats = bbp_get_statistics();
    if ( function_exists( 'bbp_get_statistics' ) ) {
        echo esc_html( $stats['reply_count'] );
    } else {
        echo '0';
    }
}

// BbPress Topic Tag Count
function disputo_bbpress_topic_tag_count() {
    $stats = bbp_get_statistics();
    if ( function_exists( 'bbp_get_statistics' ) ) {
        echo esc_html( $stats['topic_tag_count'] );
    } else {
        echo '0';
    }
}
?>