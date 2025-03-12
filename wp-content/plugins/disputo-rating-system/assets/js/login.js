function like(event) {
    event.preventDefault();
    var has_id = jQuery(this).prev();
    var id = has_id.val();
    like_ajax(id);
}

function like_ajax(id) {
    var like = jQuery('.disputo-p-like-counter.' + id);
    like.text(disputo_login.text);
}


function dislike(event) {
    event.preventDefault();
    var has_id = jQuery(this).prev();
    var id = has_id.val();
    dislike_ajax(id);
}

function dislike_ajax(id) {
    var dislike = jQuery('.disputo-p-dislike-counter.' + id);
    dislike.text(disputo_login.text);
}

jQuery(document).ready(function () {
    jQuery(document.body).off('click.disputolike', '.disputo-p-like').one('click.disputolike', '.disputo-p-like', like);
    jQuery(document.body).off('click.disputodislike', '.disputo-p-dislike').one('click.disputodislike', '.disputo-p-dislike', dislike);
});