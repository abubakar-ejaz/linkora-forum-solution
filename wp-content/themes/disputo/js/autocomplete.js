(function( $ ) {
	$(function() {
		var url = DisputoAutocomplete.url + "?action=disputo_ajax_search";
        var url2 = DisputoAutocomplete.url + "?action=disputo_ajax_post_search";
        
		$( "#bbp-header-search-form" ).find('.form-control').autocomplete({
			source: url,
            search: function(){
                $("#bbp-header-search-form").addClass('disputo_ajax_search_loading');
            },
            open : function(){
                $("#bbp-header-search-form").removeClass('disputo_ajax_search_loading');
            },
            select: function( event, ui ) { 
                event.preventDefault();
                window.location.href = ui.item.value;
            },
			delay: 500,
			minLength: 3
		});	
        
        $("#disputo-header-search-form").find('.form-control').autocomplete({
            source: url2,
            search: function () {
                $("#disputo-header-search-form").addClass('disputo_ajax_search_loading');
            },
            open: function () {
                $("#disputo-header-search-form").removeClass('disputo_ajax_search_loading');
            },
            select: function (event, ui) {
                event.preventDefault();
                window.location.href = ui.item.value;
            },
            delay: 500,
            minLength: 3
        });
	});
    

})( jQuery );