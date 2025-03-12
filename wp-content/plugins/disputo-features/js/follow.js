jQuery(document).ready(function() {

    //send topics params to callback function
    jQuery(document).on('click', '.bbpf_follow', function(e) {
        e.preventDefault();
        var grand_parent = jQuery(this).parent().parent();
        jQuery(this).parent().find('.fb_load_container').show();

        jQuery.ajax({
            type: "POST", // use $_POST request to submit data
            url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
            data: {
                action: 'bbpf_follow', // wp_ajax_*, wp_ajax_nopriv_*
                security: bbpf_ajax_url.check_nonce,
                follow_user_id: jQuery(this).data('user_id')
            },
            success: function(data) {
                //display AJAX results
                grand_parent.html(data); //
                grand_parent.find('.fb_load_container').hide();


            },
            error: function() {
                console.log(errorThrown); // error
            }
        });

    });
    jQuery(document).on('click', '.bbpf_follow_from_list', function(e) {
        e.preventDefault();
        var grand_parent = jQuery(this).parent();

        jQuery.ajax({
            type: "POST", // use $_POST request to submit data
            url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
            data: {
                action: 'bbpf_follow_from_list', // wp_ajax_*, wp_ajax_nopriv_*
                security: bbpf_ajax_url.check_nonce,
                follow_user_id: jQuery(this).data('user_id')
            },
            success: function(data) {
                //display AJAX results
                console.log(data);
                grand_parent.html(data); //


            },
            error: function() {
                console.log(errorThrown); // error
            }
        });

    });
    jQuery(document).on('click', '.bbpf_unfollow', function(e) {
        e.preventDefault();
        var grand_parent = jQuery(this).parent().parent();
        jQuery(this).parent().find('.fb_load_container').show();

        jQuery.ajax({
            type: "POST", // use $_POST request to submit data
            url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
            data: {
                action: 'bbpf_unfollow', // wp_ajax_*, wp_ajax_nopriv_*
                security: bbpf_ajax_url.check_nonce,
                unfollow_user_id: jQuery(this).data('user_id')
            },
            success: function(data) {
                //display AJAX results
                grand_parent.html(data); //
                grand_parent.find('.fb_load_container').hide();


            },
            error: function() {
                console.log(errorThrown); // error
            }
        });

    });
    //----- OPEN
    var stop_loading_followers = 0;
    jQuery(document).on('click', 'a.bbpf_followers_link', function(e) {
        e.preventDefault();
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        jQuery('[data-popup="' + targeted_popup_class + '"]').css('display', 'flex');
        if (jQuery('.bbpf_follower_list').find('.bbpf_view_list').is(':empty')) {
            jQuery('.bbpf_follower_list').find('.fb_load_container').show();
            jQuery.ajax({
                type: "POST", // use $_POST request to submit data
                url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
                data: {
                    action: 'bbpf_follower_list', // wp_ajax_*, wp_ajax_nopriv_*
                    security: bbpf_ajax_url.check_nonce,
                    list_user_id: jQuery('[data-popup="' + targeted_popup_class + '"]').data('user_id'),
                    item_limit: jQuery('[data-popup="' + targeted_popup_class + '"]').data('item_limit')
                },
                success: function(data) {
                    //display AJAX results
                    jQuery('.bbpf_follower_list').find('.fb_load_container').hide();
                    jQuery('.bbpf_follower_list').find('.bbpf_view_list').append(data); //

                },
                error: function() {
                    console.log(errorThrown); // error
                }
            });
        }

        jQuery('.bbpf_follower_list .bbpf_view_list').on('scroll', function() {
            e.preventDefault();
            let follower_count = jQuery(this).find('.bbpf_follow_list_container').length;
            let item_num = parseInt(jQuery(this).parent().parent().data('item_limit'));
            if (jQuery(this).scrollTop() >= jQuery(this).parent().height() - jQuery(this).height() - 12) {
                // ajax call get data from server and append to the div
                if (stop_loading_followers == 0 && (follower_count % item_num == 0)) {
                    stop_loading_followers = 1;
                    jQuery('.bbpf_follower_list').find('.fb_load_container').show();
                    jQuery.ajax({
                        type: "POST", // use $_POST request to submit data
                        url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
                        data: {
                            action: 'bbpf_follower_list', // wp_ajax_*, wp_ajax_nopriv_*
                            security: bbpf_ajax_url.check_nonce,
                            list_user_id: jQuery(this).parent().parent().data('user_id'),
                            item_limit: item_num,
                            list_offset: follower_count
                        },
                        success: function(data) {
                            //display AJAX results
                            jQuery('.bbpf_follower_list').find('.fb_load_container').hide();
                            jQuery('.bbpf_follower_list').find('.bbpf_view_list').append(data); //
                            stop_loading_followers = 0;
                            let new_follower_count = jQuery(this).find('.bbpf_follow_list_container').length;
                            if (new_follower_count - follower_count < item_num) {
                                stop_loading_followers = 1;
                            }
                        },
                        error: function() {
                            console.log(errorThrown); // error
                        }
                    });
                }

            }
        });


    });

    var stop_loading_following = 0;
    jQuery(document).on('click', 'a.bbpf_following_link', function(e) {
        e.preventDefault();
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        jQuery('[data-popup="' + targeted_popup_class + '"]').css('display', 'flex');
        if (jQuery('.bbpf_following_list').find('.bbpf_view_list').is(':empty')) {
            jQuery('.bbpf_following_list').find('.fb_load_container').show();
            jQuery.ajax({
                type: "POST", // use $_POST request to submit data
                url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
                data: {
                    action: 'bbpf_following_list', // wp_ajax_*, wp_ajax_nopriv_*
                    security: bbpf_ajax_url.check_nonce,
                    list_user_id: jQuery('[data-popup="' + targeted_popup_class + '"]').data('user_id'),
                    item_limit: jQuery('[data-popup="' + targeted_popup_class + '"]').data('item_limit')
                },
                success: function(data) {
                    //display AJAX results
                    jQuery('.bbpf_following_list').find('.fb_load_container').hide();
                    jQuery('.bbpf_following_list').find('.bbpf_view_list').append(data); //

                },
                error: function() {
                    console.log(errorThrown); // error
                }
            });
        }


        jQuery('.bbpf_following_list .bbpf_view_list').on('scroll', function() {
            e.preventDefault();
            let following_count = jQuery(this).find('.bbpf_follow_list_container').length;
            let item_num = parseInt(jQuery(this).parent().parent().data('item_limit'));

            if (jQuery(this).scrollTop() >= jQuery(this).parent().height() - jQuery(this).height() - 12) {
                // ajax call get data from server and append to the div

                if (stop_loading_following == 0 && (following_count % item_num == 0)) {
                    stop_loading_following = 1;
                    jQuery('.bbpf_following_list').find('.fb_load_container').show();
                    jQuery.ajax({
                        type: "POST", // use $_POST request to submit data
                        url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
                        data: {
                            action: 'bbpf_following_list', // wp_ajax_*, wp_ajax_nopriv_*
                            security: bbpf_ajax_url.check_nonce,
                            list_user_id: jQuery(this).parent().parent().data('user_id'),
                            item_limit: item_num,
                            list_offset: following_count
                        },
                        success: function(data) {
                            //display AJAX results
                            jQuery('.bbpf_following_list').find('.fb_load_container').hide();
                            jQuery('.bbpf_following_list').find('.bbpf_view_list').append(data); //
                            stop_loading_following = 0;
                            let new_following_count = jQuery(this).find('.bbpf_follow_list_container').length;

                            if (new_following_count - following_count < item_num) {
                                stop_loading_following = 1;
                            }
                        },
                        error: function() {
                            console.log(errorThrown); // error
                        }
                    });
                }

            }
        });

    });

    jQuery(document).click(function(e) {

        if (jQuery(".popup-inner").is(":visible")) {
            if (!(jQuery(e.target).is('.popup-inner,.popup-inner *')) && !(jQuery(e.target).is('.bbpf_followers_link')) && !(jQuery(e.target).is('.bbpf_following_link'))) {
                jQuery(".popup").css('display', 'none');
            }

        }
    });
    jQuery(document).on('click', '[data-popup-close]', function(e) {
        e.preventDefault();
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        var cur_user_id = jQuery(this).data('user_id');
        jQuery('[data-popup="' + targeted_popup_class + '"]').css('display', 'none');

        if ((typeof cur_user_id !== "undefined") && (parseInt(cur_user_id) != 0)) {

            jQuery.ajax({
                type: "POST", // use $_POST request to submit data
                url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
                data: {
                    action: 'bbpf_update_user_profile', // wp_ajax_*, wp_ajax_nopriv_*
                    security: bbpf_ajax_url.check_nonce,
                    cur_user_id: jQuery(this).data('user_id')
                },
                success: function(data) {
                    //display AJAX results
                    jQuery(".follow_box_container").html(data); //
                    stop_loading_following = 0;
                    stop_loading_followers = 0;

                },
                error: function() {
                    console.log(errorThrown); // error
                }
            });

        }


    });
    jQuery('.bbpf_topic_btn').on('click', function(e) {
        e.preventDefault();
        var grand_parent = jQuery(this).parent().parent();
        jQuery(this).parent().find('.bbpf_topic_loading').show();
        //number of loaded topics
        let topic_count = grand_parent.find('.bbpf_topic_item').length;
        let item_count = parseInt(jQuery(this).data('item_limit'));

        jQuery.ajax({
            type: "POST", // use $_POST request to submit data
            url: bbpf_ajax_url.ajax_url, // URL to "wp-admin/admin-ajax.php"
            data: {
                action: 'bbpf_get_wall_topics', // wp_ajax_*, wp_ajax_nopriv_*
                security: bbpf_ajax_url.check_nonce,
                wall_item_limit: jQuery(this).data('item_limit'),
                wall_word_limit: jQuery(this).data('word_limit'),
                wall_title_limit: jQuery(this).data('title_limit'),
                wall_offset: topic_count
            },
            beforeSend: function() {
                grand_parent.find('.bbpf_topic_btn').html(grand_parent.find('.bbpf_topic_btn').data('loadingtxt'));
                grand_parent.find('.bbpf_topic_btn').css('pointer-events', 'none');
            },
            success: function(data) {
                //display AJAX results
                grand_parent.find('.bbpf_topic_item').last().fadeOut(1).after(data).fadeIn(500);
                var newcount = grand_parent.find('.bbpf_topic_item').length;
                //hide load more button
                if (newcount - topic_count < item_count) {
                    grand_parent.find('.bbpf_topic_btn').html(grand_parent.find('.bbpf_topic_btn').data('noposts'));
                    grand_parent.find('.bbpf_topic_btn').removeClass('btn-primary');
                    grand_parent.find('.bbpf_topic_btn').addClass('btn-light');
                    grand_parent.find('.bbpf_topic_btn').css('pointer-events', 'none');
                } else {
                    grand_parent.find('.bbpf_topic_btn').html(grand_parent.find('.bbpf_topic_btn').data('loadtxt'));
                    grand_parent.find('.bbpf_topic_btn').css('pointer-events', 'auto');
                }
            },
            error: function() {
                console.log(errorThrown); // error
            }
        });



    });


});