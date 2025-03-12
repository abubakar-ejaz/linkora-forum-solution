jQuery(document).ready(function ($) {
    $("#continent").change(function () {
        var continent = $(this).val();
        $.post(bbp_custom_search.ajax_url, {
            action: "get_countries_by_continent",
            continent_slug: continent
        }, function (response) {
            $("#country").html(response).prop("disabled", false);
            $("#city, #category").html('<option value="">Select</option>').prop("disabled", true);
        });
    });

    $("#country").change(function () {
        var country = $(this).val();
        if (country) {
            $.post(bbp_custom_search.ajax_url, {
                action: "get_cities_by_country",
                country_slug: country
            }, function (response) {
                $("#city").html(response).prop("disabled", false);
                $("#category").html('<option value="">Select</option>').prop("disabled", true);
            });
        } else {
            $("#city, #category").html('<option value="">Select</option>').prop("disabled", true);
        }
    });

    $("#city").change(function () {
        var city = $(this).val();
        if (city) {
            $.post(bbp_custom_search.ajax_url, {
                action: "get_categories_by_city",
                city_slug: city
            }, function (response) {
                $("#category").html(response).prop("disabled", false);
            });
        } else {
            $("#category").html('<option value="">Select</option>').prop("disabled", true);
        }
    });

    // ✅ Handle Form Submission for independent searches
    $("#bbp-header-search-form").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        var continent = $("#continent").val();
        var country = $("#country").val();
        var city = $("#city").val();
        var category = $("#category").val();

        // ✅ Build URL based on selected fields
        var url = "/location/";

        if (continent) {
            url += continent + "/";
        }
        if (country) {
            url += country + "/";
        }
        if (city) {
            url += city + "/";
        }
        if (category) {
            url += category.replace(/&/g, "and").replace(/\s+/g, "-").toLowerCase() + "/";
        }

        // If nothing is selected, show an alert
        if (!continent && !country && !city && !category) {
            alert("Please select at least one field to search.");
            return;
        }

        // Redirect to the generated URL
        window.location.href = url;
    });
});
