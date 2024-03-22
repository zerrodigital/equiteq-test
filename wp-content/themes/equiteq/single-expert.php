<?php

get_header();
$id = get_the_ID();
$expert = get_expert($id);
// $industry_expertises = maybe_unserialize($expert->industry_expertise);
?>


<section id="single-expert">
    <div class="container no-pad-gutters">
        <div class="back mb-4 mb-md-5">
            <i class="fa fa-caret-left align-bottom" style="font-size: 22px;" aria-hidden="true"></i> <a
                href="<?php echo site_url();?>/experts/" class="btn-outline-success text-uppercase px-0 ml-2">Back to team</a>
        </div>
        <!--May implement the expert's profile here -->
            
        <div class="expert-wrapper">
        <?php

        if (have_posts()) :
            while (have_posts()) :
                the_post();
                $expert_name = get_the_title();
                $expert_content = get_the_content();
                $expert_title = get_field('title'); 
                $expert_image = get_field('profile_image'); 
                $expert_location = get_field('location'); 
                $expert_email = get_field('email'); 
                $expert_phone = get_field('phone'); 
                $expert_linkedin = get_field('linkedin'); 
                $expert_industry = get_field('industry_expertise'); 
                ?>

                <div class="expert-row">
                    <div class="expert-leftcol">
                        <div class="expert-bgimg">
                            <img src="<?php echo $expert_image; ?>" alt="<?php echo $expert_name; ?>">
                        </div>
                    </div>
                    <div class="expert-rightcol">
                        <div class="name">
                            <h1><?php echo $expert_name; ?></h1>
                        </div>
                        <div class="title">
                            <h6><?php echo $expert_title; ?></h6>
                        </div>
                        <div class="location">
                            <p>
                                <i class="fa fa-map-marker fa-lg text-green" aria-hidden="true"></i>
                                <?php echo esc_html( $expert_location->post_title ); ?>
                            </p>
                        </div>
                        <div class="social-icon">
                            <ul>
                                <li><a href="mailto:<?php echo $expert_email; ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                                <li><a href="tel:<?php echo $expert_phone; ?>"><i class="fa fa-phone" aria-hidden="true"></i></a></li>
                                <li><a href="<?php echo $expert_linkedin; ?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <div class="content-text">
                            <?php echo $expert_content; ?>
                        </div>
                    </div>
                </div>

            <?php endwhile;
        else :
            // No expert found
            echo '<p>No expert found.</p>';
        endif;

        ?>
        </div><!-- expert-wrapper -->

    </div>
</section>


<!--May implement the expert's industry expertise here -->
<div id="expertise" class="bg-dark-blue px-5 py-2">
    <div class="container text-white no-pad-gutters mx-5">
        <h3 class="text-uppercase mt-5 mb-4">EXPERTISE</h3>
        <?php
        $expertises = get_field('industry_expertise');
        if( $expertises ): ?>
            <div class="row mt-5">
            <?php foreach( $expertises as $post ): 

                // Setup this post for WP functions (variable must be named $post).
                setup_postdata($post); 
            ?>
                <div class="col-4 exp">
                    <div class="img-wrap">
                        <img src="<?php echo get_field('icon'); ?>" alt="<?php the_title(); ?> icon">
                    </div>
                    <div class="text"><?php the_title(); ?></div>
                </div>  
            <?php endforeach; ?>
            </div>
            <?php 
            // Reset the global post object so that the rest of the page works correctly.
            wp_reset_postdata(); ?>
        <?php endif; ?>  
    </div>
</div>

<?php
get_footer();