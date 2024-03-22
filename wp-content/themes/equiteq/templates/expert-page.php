<?php
/* Template Name: Expert Page */
get_header();
$id = get_the_ID();
$page = get_post($id);
?>

<?php

/**Hero */
// hm_get_template_part('template-parts/hero', ['page' => $page]);

?>

<section class="bg-dark-blue">
    <div class="container text-white no-pad-gutters">
        <h3 class="text-uppercase mt-5 mb-4"><?php echo $page->post_title ?></h3>
        <div class="row">
            <div class="col-md-8 mb-4">
                <?php echo $page->post_content ?>
            </div>
        </div>
        <!--May implement the search and filter here-->
        <div class="listing-options">
            <div class="filter-wrap">
            <h4>FILTERS</h4>
            <div class="filter-list">
                <div id="filter-industry" class="filterbox">
                    <label>
                        <span>All</span> <i class="fa fa-caret-down"></i>
                    </label>
                    <?php
                    $args1 = array(
                        'post_type' => 'industry', 
                        'posts_per_page' => -1 // To retrieve all experts
                    );
                    $industry_query = new WP_Query($args1);

                    if ($industry_query->have_posts()) :
                    ?>
                    <ul class="filter-dropdown">
                        <li class="selected"><a href="all">All</a></li>
                        <?php
                            while ($industry_query->have_posts()) :
                            $industry_query->the_post();
                        ?>
                        <li><a href="<?php echo get_post_field( 'post_name', get_post() ); ?>"><?php echo get_the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <div class="vertical-divider"></div>
                <div id="filter-location" class="filterbox">
                    <label>
                        <span>All</span> <i class="fa fa-caret-down"></i>
                    </label>
                    <?php
                    $args2 = array(
                        'post_type' => 'location', 
                        'posts_per_page' => -1 // To retrieve all experts
                    );
                    $location_query = new WP_Query($args2);

                    if ($location_query->have_posts()) :
                    ?>
                    <ul class="filter-dropdown">
                        <li class="selected"><a href="all">All</a></li>
                        <?php
                            while ($location_query->have_posts()) :
                            $location_query->the_post();
                        ?>
                        <li><a href="<?php echo get_post_field( 'post_name', get_post() ); ?>"><?php echo get_the_title(); ?></a></li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div><!-- filter-list -->
            </div><!-- filter-wrap -->

            <div class="search-wrap">
                <h4>SEARCH</h4>
                <div class="search-input">
                    <input type="text" placeholder="Search...">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!--May implement the experts profile list here-->

<section class="page-center">
    
<?php
$args = array(
    'post_type' => 'expert', 
    'posts_per_page' => -1 // To retrieve all experts
);
$experts_query = new WP_Query($args);

if ($experts_query->have_posts()) :
?>
    <div class="team-experts">
        <?php
        while ($experts_query->have_posts()) :
            $experts_query->the_post();
            $expert_name = get_the_title();
            $expert_title = get_field('title'); 
            $expert_location = get_field('location'); 
            $expert_email = get_field('email'); 
            $expert_phone = get_field('phone'); 
            $expert_linkedin = get_field('linkedin'); 
            $expertises = get_field('industry_expertise');

            $exp_classes = "";
            if( $expertises ):
            foreach( $expertises as $exp ):
                $exp_slug = $exp->post_name;
                $exp_classes .= $exp_slug." ";
            endforeach;
            endif;

            $loc_class = $expert_location->post_name;
        ?>

            <div class="expert-box <?php echo $exp_classes; ?> <?php echo $loc_class; ?>">
                <div class="expert-img">
                    <a href="<?php the_permalink(); ?>">
                        <?php if( get_field('profile_image') ): ?>
                        <img src="<?php the_field('profile_image'); ?>"alt="<?php echo esc_attr($expert_name); ?> Profile Image" />
                        <?php endif; ?>
                    </a>
                </div>
                <div class="expert-name">
                    <a href="<?php the_permalink(); ?>"><?php echo $expert_name; ?></a>
                </div>
                <div class="expert-title"><?php echo $expert_title; ?></div>
                <div class="expert-location"><?php echo esc_html( $expert_location->post_title ); ?></div>
                <div class="social-icons">
                    <ul class="experts-socials p-0 align-items-center">
                        <li><a href="mailto:<?php echo $expert_email; ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                        <li><a href="tel:<?php echo $expert_phone; ?>"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                        <li><a href="<?php echo $expert_linkedin; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div> <!-- expert-box -->

        <?php
        endwhile;
        ?>
    </div> <!-- .expert-experts -->
<?php
    wp_reset_postdata();
else :
    // No experts found
    echo '<p>No experts found.</p>';
endif;
?>
</section>


<script>

    $(document).ready(function() {
        $('.filterbox label').click(function() {
            var filterDropdown = $(this).next('.filter-dropdown');

            // Check if the filter-dropdown is already active
            if (filterDropdown.hasClass('active')) {
                // Remove active class from all filter-dropdown elements
                $('.filter-dropdown').removeClass('active');
            } else {
                // Remove active class from all filter-dropdown elements
                $('.filter-dropdown').removeClass('active');
                // Add active class to the next filter-dropdown element
                filterDropdown.addClass('active');
            }
        });


        // Function to filter expert-box elements based on search query
        function filterExperts(searchText) {
            $('.expert-box').each(function() {
                var expertName = $(this).find('.expert-name a').text().trim().toLowerCase();

                if (expertName.includes(searchText)) {
                    $(this).removeClass('hide');
                } else {
                    $(this).addClass('hide');
                }
            });
        }

        // Function to handle filter dropdown selection
        function filterByDropdowns() {
            var industrySlug = $('#filter-industry .filter-dropdown .selected a').attr('href').replace('#', '');
            var locationSlug = $('#filter-location .filter-dropdown .selected a').attr('href').replace('#', '');

            // Show expert-box elements matching selectedSlug and not already hidden
            $('.expert-box').removeClass('hide');

            // Hide expert-box elements not matching selectedSlug
            if (industrySlug !== 'all') {
                $('.expert-box').not('.' + industrySlug).addClass('hide');
            }

            // If 'all' is not selected in location filterbox, hide expert-box elements not matching locationSlug
            if (locationSlug !== 'all') {
                $('.expert-box').not('.' + locationSlug).addClass('hide');
            }
        }

        // Search input event listener
        $('.search-input input').on('input', function() {
            var searchText = $(this).val().trim().toLowerCase();
            filterExperts(searchText);
        });

        // Reset search and filter dropdowns when search input is cleared
        $('.search-input input').on('keyup', function(event) {
            if (event.keyCode === 27 && $(this).val() === '') { // Detect Escape key
                $(this).val(''); // Clear input field
                filterByDropdowns(); // Filter by dropdowns
            }
        });

        // Filter dropdown selection event listener
        $('.filter-dropdown a').click(function(e) {
            e.preventDefault();
            $(this).closest('.filter-dropdown').find('li').removeClass('selected');
            $(this).parent('li').addClass('selected');
            var selectedText = $(this).text();
            $(this).closest('.filterbox').find('label span').text(selectedText);
            filterByDropdowns();
        });


    });

</script>

<?php
get_footer();
?>