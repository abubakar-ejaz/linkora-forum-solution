/* FAQ NAVIGATION */
jQuery("#disputo-faq-page").find(".disputo-faq-menu a").on('click', function (event) {
    "use strict";
    event.preventDefault();
    var searchTerm = jQuery("#disputo-faq-page").find('.disputo-live-search-box').val().toLowerCase();
    var goto = jQuery(this).data("cat");
    jQuery('body,html').animate({
        scrollTop: jQuery("#" + goto).offset().top - 40
    }, 500);
    return false;
});

/* FAQ LIVE SEARCH */
jQuery("#disputo-faq-page").find('.disputo-live-search-results').each(function () {
    "use strict";
    jQuery(this).attr('data-search-term', jQuery(this).find(".mp-accordion-title").text().toLowerCase());
});

jQuery("#disputo-live-search-container").find('.disputo-live-search-icon').on('click', function () {
    "use strict";
    var faqbody = jQuery("#disputo-faq-cat-container");
    jQuery("#disputo-faq-page").find(".disputo-faq-menu").removeClass("menu-is-disabled");
    jQuery("#disputo-live-search-container").find(".disputo-live-search-box").val("");
    jQuery("#disputo-live-search-container").removeClass("cancel-search");
    faqbody.find(".disputo-faq-cat-title").show();
    faqbody.find(".disputo-faq-container").removeClass("disputo-no-result");
    jQuery("#disputo-no-results-message").hide();
    jQuery("#disputo-faq-cat-container").show();
    faqbody.find('.disputo-live-search-results').show();
});

jQuery("#disputo-faq-page").find('.disputo-live-search-box').on('keyup', function () {
    "use strict";
    jQuery("#disputo-no-results-message").hide();
    jQuery("#disputo-faq-cat-container").show();
    var searchTerm = jQuery(this).val().toLowerCase();
    var faqbody = jQuery("#disputo-faq-cat-container");
    if ((searchTerm == '') || (searchTerm.length < 1)) {
        jQuery("#disputo-faq-page").find(".disputo-faq-menu").removeClass("menu-is-disabled");
        jQuery("#disputo-live-search-container").removeClass("cancel-search");
        faqbody.find(".disputo-faq-cat-title").show();
        faqbody.find(".disputo-faq-container").removeClass("disputo-no-result");
    } else {
        jQuery("#disputo-faq-page").find(".disputo-faq-menu").addClass("menu-is-disabled");
        jQuery("#disputo-live-search-container").addClass("cancel-search");
        faqbody.find(".disputo-faq-cat-title").hide();
        faqbody.find(".disputo-faq-container").addClass("disputo-no-result");
    }
    faqbody.find('.disputo-live-search-results').each(function () {
        if (jQuery(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
            jQuery(this).show();
        } else {
            jQuery(this).hide();
        }
    });
    if (faqbody.find(".disputo-live-search-results:visible").length === 0) {
        jQuery("#disputo-no-results-message").show();
        jQuery("#disputo-faq-cat-container").hide();
    }
});