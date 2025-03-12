	function like_comment(event) {
	    event.preventDefault();
	    var has_id = jQuery(this).parent().children('input');
	    var id = has_id.val();
	    like_ajax_comment(id);
	}

	function like_ajax_comment(id) {
	    var like = jQuery('.disputo-p-like-counter-comment.' + id);
	    like.text(disputo_login_comment.text);
	}


	function dislike_comment(event) {
	    event.preventDefault();
	    var has_id = jQuery(this).parent().children('input');
	    var id = has_id.val();
	    dislike_ajax_comment(id);
	}

	function dislike_ajax_comment(id) {
	    var dislike = jQuery('.disputo-p-dislike-counter-comment.' + id);
	    dislike.text(disputo_login_comment.text);
	}

	jQuery(document).ready(function () {
	    jQuery(document.body).off('click.disputolikecomment', '.disputo-p-like-comment').one('click.disputolikecomment', '.disputo-p-like-comment', like_comment);
	    jQuery(document.body).off('click.disputodislikecomment', '.disputo-p-dislike-comment').one('click.disputodislikecomment', '.disputo-p-dislike-comment', dislike_comment);
	});