<?php get_header(); ?>
<?php
$disputo_search_query = get_search_query();
$disputo_archive_page_layout = esc_attr(get_theme_mod('disputo_archive_page_layout', 'twocolumnssidebar'));
$disputo_no_boxed = get_theme_mod('disputo_no_boxed'); 
?>
<div id="header-wrapper">
    <header>
        <?php get_template_part( 'templates/header', 'template'); ?>
    </header>
    <?php get_template_part( 'templates/cover', 'template'); ?>
    <div class="disputo-page-title <?php if($disputo_no_boxed) { echo 'noboxed-title'; } ?>">
        <div class="container">
        <h1>
        <?php if ( have_posts() ) {
        global $wp_query;
        $disputo_post_count = $wp_query->found_posts;
        echo '<span>' . $disputo_post_count . ' </span> ';
        if ($disputo_post_count > 1) {
            echo esc_html__( 'Results Found', 'disputo' );
        }
        else {
            echo esc_html__( 'Result Found', 'disputo' );
        }
        }
        else {
            echo esc_html__( 'No Results Found', 'disputo' );
        }
        ?>
        </h1>
  
        </div>
    </div>
</div>
<?php if ( have_posts() ) { ?>
    <main class="disputo-main-container">
    <div class="container">
    <div id="disputo-main-inner" class=" <?php if($disputo_no_boxed) { echo 'nomargin noboxed'; } ?>">
        <?php if ($disputo_archive_page_layout == 'twocolumns') { ?>
            <div class="disputo-masonry-grid">
                <div class="disputo-two-columns" data-columns>
                    <?php while(have_posts()) : the_post(); ?>
                    <?php get_template_part( 'templates/masonry', 'template'); ?>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php if ( (get_next_posts_link()) || (get_previous_posts_link())) : ?>
            <div class="disputo-pager">
                <?php disputo_pagination(); ?>
            </div> 
            <div class="clearfix"></div>    
            <?php endif; ?>
            <?php } else if ($disputo_archive_page_layout == 'threecolumns') { ?>
            <div class="disputo-masonry-grid">
                <div class="disputo-three-columns" data-columns>
                    <?php while(have_posts()) : the_post(); ?>
                    <?php get_template_part( 'templates/masonry', 'template'); ?>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php if ( (get_next_posts_link()) || (get_previous_posts_link())) : ?>
                <div class="disputo-pager">
                    <?php disputo_pagination(); ?>
                </div> 
                <div class="clearfix"></div>    
            <?php endif; ?>
            <?php } else if ($disputo_archive_page_layout == 'fourcolumns') { ?>
            <div class="disputo-masonry-grid">
                <div class="disputo-four-columns" data-columns>
            <?php while(have_posts()) : the_post(); ?>
            <?php get_template_part( 'templates/xsmasonry', 'template'); ?>
            <?php endwhile; ?>
                </div>
            </div>
            <?php if ( (get_next_posts_link()) || (get_previous_posts_link())) : ?>
                <div class="disputo-pager">
                    <?php disputo_pagination(); ?>
                </div> 
                <div class="clearfix"></div>    
            <?php endif; ?>
            <?php } else if ($disputo_archive_page_layout == 'onecolumn') { ?> 
            <div class="disputo-page-left <?php if ( !is_active_sidebar( 'disputo_sidebar' ) ) { ?>disputo-page-full<?php } ?>">       
                <div class="disputo-masonry-grid">
                    <div class="disputo-one-column" data-columns>
                <?php while(have_posts()) : the_post(); ?>
                <?php get_template_part( 'templates/lgmasonry', 'template'); ?>
                <?php endwhile; ?>
                    </div>
                </div>
                <?php if ( (get_next_posts_link()) || (get_previous_posts_link())) : ?>
                    <div class="disputo-pager">
                        <?php disputo_pagination(); ?>
                    </div> 
                    <div class="clearfix"></div>    
                <?php endif; ?> 
            </div>
            <?php if ( is_active_sidebar( 'disputo_sidebar' ) ) { ?>
            <aside class="disputo-page-right">
                <?php dynamic_sidebar( 'disputo_sidebar' ); ?>
            </aside>
            <?php } ?>
            <div class="clearfix"></div>
            <?php } else { ?>  
            <div class="disputo-page-left <?php if ( !is_active_sidebar( 'disputo_sidebar' ) ) { ?>disputo-page-full<?php } ?>">      
                <div class="disputo-masonry-grid">
                    <div class="disputo-two-columns" data-columns>
                <?php while(have_posts()) : the_post(); ?>
                <?php get_template_part( 'templates/masonry', 'template'); ?>
                <?php endwhile; ?>
                    </div>
                </div>
                <?php if ( (get_next_posts_link()) || (get_previous_posts_link())) : ?>
                    <div class="disputo-pager">
                        <?php disputo_pagination(); ?>
                    </div> 
                    <div class="clearfix"></div>    
                <?php endif; ?> 
            </div>
            <?php if ( is_active_sidebar( 'disputo_sidebar' ) ) { ?>
            <aside class="disputo-page-right">
                <?php dynamic_sidebar( 'disputo_sidebar' ); ?>
            </aside>
            <?php } ?>
            <div class="clearfix"></div> 
            <?php } ?>
    </div>
    </div>
</main>
<?php } else { ?>
    <main class="disputo-main-container">
    <div class="container">    
        <div id="disputo-main-inner">
            <p class="lead"><?php esc_html_e( 'You can search for the page you were looking for or;', 'disputo'); ?></p>
            <p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return Home', 'disputo' ); ?></a></p>
        </div>
    </div>
</main>
<?php } ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const continents = {
        "asia": ["Pakistan", "India", "China"],
        "europe": ["Germany", "France", "UK"],
        "north-america": ["USA", "Canada", "Mexico"]
    };

    const cities = {
        "Pakistan": ["Lahore", "Karachi", "Islamabad"],
        "India": ["Delhi", "Mumbai", "Bangalore"],
        "USA": ["New York", "Los Angeles", "Chicago"]
    };

    let continentSelect = document.getElementById("continent");
    let countrySelect = document.getElementById("country");
    let citySelect = document.getElementById("city");
    let searchBtn = document.getElementById("search-btn");

    // Enable country dropdown on continent selection
    continentSelect.addEventListener("change", function () {
        countrySelect.innerHTML = '<option value="">Select Country</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';
        citySelect.disabled = true;
        searchBtn.disabled = true;

        let selectedContinent = continentSelect.value;
        if (selectedContinent && continents[selectedContinent]) {
            countrySelect.disabled = false;
            continents[selectedContinent].forEach(country => {
                let option = new Option(country, country);
                countrySelect.add(option);
            });
        } else {
            countrySelect.disabled = true;
        }
    });

    // Enable city dropdown on country selection
    countrySelect.addEventListener("change", function () {
        citySelect.innerHTML = '<option value="">Select City</option>';
        searchBtn.disabled = true;

        let selectedCountry = countrySelect.value;
        if (selectedCountry && cities[selectedCountry]) {
            citySelect.disabled = false;
            cities[selectedCountry].forEach(city => {
                let option = new Option(city, city);
                citySelect.add(option);
            });
        } else {
            citySelect.disabled = true;
        }
    });

    // Enable search button on city selection
    citySelect.addEventListener("change", function () {
        searchBtn.disabled = citySelect.value === "";
    });

    // Redirect search button to results
    searchBtn.addEventListener("click", function () {
        let continent = continentSelect.value;
        let country = countrySelect.value;
        let city = citySelect.value;
        window.location.href = `/search-results?continent=${continent}&country=${country}&city=${city}`;
    });
});
</script>
<?php get_footer(); ?>