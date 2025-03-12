(function ($) {
    "use strict";
    var disputo_get_selection = function () {
        var t = '';
        if (window.getSelection) {
            t = window.getSelection();
        } else if (document.getSelection) {
            t = document.getSelection();
        } else if (document.selection) {
            t = document.selection.createRange().text;
        }
        return jQuery.trim(t.toString());
    };

    var is_editor_active = function (editor_id) {
        var editor = '';
        if (typeof tinyMCE == 'undefined') {
            return false;
        }
        if (typeof editor_id == 'undefined') {
            editor = tinyMCE.activeEditor;
        } else {
            editor = tinyMCE.EditorManager.get(editor_id);
        }
        if (editor == null) {
            return false;
        }
        return !editor.isHidden();
    };

    $('#bbpress-forums').find('.disputo-get-quote').on('click', function (e) {
        e.preventDefault();
        var wp_editor = disputo_dropdown_vars.disputo_wp_editor;
        var reply_id = '#' + $(this).data('quote');
        var reply_author = $(this).data('author');
        var reply_url = $(this).data('url');
        var reply_content = disputo_get_selection();

        if (reply_content === "") {
            reply_content = $(reply_id).html();
        }

        reply_content = '[bquote]\n<a href="' + reply_url + '">' + reply_author + ':</a>\n' + reply_content + '\n[/bquote]\n';

        if ((wp_editor == 1) && is_editor_active('bbp_reply_content')) {
            tinyMCE.get('bbp_reply_content').setContent(reply_content);
            $('html, body').animate({
                scrollTop: $('#wp-bbp_reply_content-wrap').offset().top - 60
            }, 500);
        } else {
            reply_content = reply_content.replace(/&nbsp;/g, " ");
            reply_content = reply_content.replace(/<p>|<br>/g, "");
            reply_content = reply_content.replace(/<\/\s*p>/g, "\n");
            reply_content = reply_content.trim();

            $('#bbp_reply_content').val(function (i, text) {
                return reply_content + text;
            });
            $('html, body').animate({
                scrollTop: $('#bbp_reply_content').offset().top - 60
            }, 500);
        }
    });
})(jQuery);