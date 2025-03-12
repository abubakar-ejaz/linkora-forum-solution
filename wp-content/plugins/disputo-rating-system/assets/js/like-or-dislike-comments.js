	function like_comment(event){
		event.preventDefault();
		var has_id = jQuery(this).parent().children('input');
		var id = has_id.val();
		like_ajax_comment(id);
	}
	
	function like_ajax_comment(id){
		jQuery.ajax({
			type: "post",
			url: disputo_ajax_comment.url,
			dataType: "json",
			data:{
				action:'disputo_system_comment_like_button',
				post_id:id,
				nonce: disputo_ajax_comment.nonce
			},
			success: function(response){
				if(response.both == 'no'){
				var like = jQuery('.disputo-p-like-counter-comment.'+id);
				like.text(response.likes);
				var like_toggle = jQuery('.disputo-p-like-comment.'+id);
				like_toggle.toggleClass('disputo-p-like-active-comment');
				}else{
					
				var dislike = jQuery('.disputo-p-dislike-counter-comment.'+id);
				dislike.text(response.dislikes);
				
				var dislike_toggle = jQuery('.disputo-p-dislike-comment.'+id);
				dislike_toggle.toggleClass('disputo-p-dislike-active-comment');
				
				var like = jQuery('.disputo-p-like-counter-comment.'+id);
				like.text(response.likes);
				
				var like_toggle = jQuery('.disputo-p-like-comment.'+id);
				like_toggle.toggleClass('disputo-p-like-active-comment');
				
				}
			},
			complete:function(){
				jQuery(document.body).one('click.disputolikecomment','.disputo-p-like-comment',like_comment);
			}
		});
	}
	
	
	function dislike_comment(event){
		event.preventDefault();
		var has_id = jQuery(this).parent().children('input');
		var id = has_id.val();
		dislike_ajax_comment(id);
	}
	
	function dislike_ajax_comment(id){
			jQuery.ajax({
			type: "post",
			url: disputo_ajax_comment.url,
			dataType: "json",
			data:{
				action:'disputo_system_comment_dislike_button',
				post_id:id,
				nonce: disputo_ajax_comment.nonce
			},
			success: function(response){
				if(response.both == 'no'){
				var dislike = jQuery('.disputo-p-dislike-counter-comment.'+id);
				dislike.text(response.dislikes);
				var dislike_toggle = jQuery('.disputo-p-dislike-comment.'+id);
				dislike_toggle.toggleClass('disputo-p-dislike-active-comment');
				}else{
					
				var dislike = jQuery('.disputo-p-dislike-counter-comment.'+id);
				dislike.text(response.dislikes);
				var dislike_toggle = jQuery('.disputo-p-dislike-comment.'+id);
				dislike_toggle.toggleClass('disputo-p-dislike-active-comment');
				
				var like = jQuery('.disputo-p-like-counter-comment.'+id);
				like.text(response.likes);	
				var like_toggle = jQuery('.disputo-p-like-comment.'+id);
				like_toggle.toggleClass('disputo-p-like-active-comment');
				
				}
			},
			complete:function(){
				jQuery(document.body).one('click.disputodislikecomment','.disputo-p-dislike-comment',dislike_comment);
			}
		});
	}

jQuery(document).ready(function() {
	if(Modernizr.touchevents){
		jQuery(document.body).on('mouseleave touchmove click', '.disputo-p-like-comment', function( event ) {
			if(jQuery(this).hasClass('disputo-p-like-active-comment')){
				var color = jQuery('.disputo-p-dislike-comment').css('color');
				jQuery(this).css('color',color);
			}else{
				jQuery(this).removeAttr('style');
			};
		});
		jQuery(document.body).on('mouseleave touchmove click', '.disputo-p-dislike-comment', function( event ) {
			if(jQuery(this).hasClass('disputo-p-dislike-active-comment')){
				var color = jQuery('.disputo-p-like-comment').css('color');
				jQuery(this).css('color',color);
			}else{
				jQuery(this).removeAttr('style');
			};
		});
	}
	jQuery(document.body).off('click.disputolikecomment','.disputo-p-like-comment').one('click.disputolikecomment','.disputo-p-like-comment',like_comment);
	jQuery(document.body).off('click.disputodislikecomment','.disputo-p-dislike-comment').one('click.disputodislikecomment','.disputo-p-dislike-comment',dislike_comment);
});