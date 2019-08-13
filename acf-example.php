<?php
/*
  Template Name: Home page
 */

get_header();
?>


<!-- Masthead -->
<header class="masthead text-white text-center">
    <div id="demo" class="carousel slide" data-ride="carousel">
        <!-- The slideshow -->
        <?php if( have_rows('slideshow') ): ?>
        <div class="carousel-inner">
            <?php
            $i =0;
            while( have_rows('slideshow') ): the_row(); 
            $desk = get_sub_field('banner_image_for_desktop');
            $mob = get_sub_field('banner_image_for_mobile');
            
            ?>
            <div class="carousel-item <?php if ($i===0): echo('active'); endif; ?>">
                <img src="<?php echo $desk['url']; ?>" alt="" class="img-fluid dest-banner">
                <img src="<?php echo $mob['url']; ?>" alt="" class="img-fluid mob-banner">
            </div>
            
            <?php $i++; endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</header>

<div class="loan text-center">
    <div class="container">
        <div class="overlay">
            <div class="container loan-over">
                <?php if( have_rows('loan_types') ): ?>
                <div class="row">
                     <?php while( have_rows('loan_types') ): the_row(); 
                     
                    $loanname = get_sub_field('loan_type_name');
                    $loanimg = get_sub_field('loan_image_icon');
                    $loanlink = get_sub_field('loan_link');
            
                     ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <a href="<?php echo $loanlink; ?>" class="loan-section">  
                            <img src="<?php echo $loanimg['url']; ?>">
                            <h2> <?php echo $loanname; ?> </h2>
                        </a>
                    </div>
                    
                    <?php endwhile; ?>    
                </div>
                <?php endif; ?>
               
            </div>
        </div>
    </div>
</div>



<!--<div style="clear: both"></div>-->
<!-- Icons Grid -->
<section class="features-icons text-center">
    <div class="container"> 
        <h1>Where We Are<br>
            <img src="<?php bloginfo('template_url'); ?>/img/line2.png"></h1> 

        <div class="row">
            <div class="col-lg-9 col-md-10 col-sm-12 mx-auto">
                <div class="row">
 <?php if( have_rows('whereweare') ): ?>
               
            <?php $i =0; while( have_rows('whereweare') ): the_row();  
                    $branch_name = get_sub_field('branch_name');
                    $servicing = get_sub_field('servicing');
                    $servicing_link = get_sub_field('servicing_link');
                    $servicing_icon = get_sub_field('servicing_icon');
                 ?>   
                    <div class="col-lg-4 col-md-4">
                        
                        <div class="features-icons-item mx-auto <?php if ($i===2): echo('commingsoon'); endif; ?>">
                            <a href="<?php echo $servicing_link; ?>">  
                                <div class="features-icons-icon">
                                    <img src="<?php echo $servicing_icon['url']; ?>">                                
                                </div>
                                <h1><?php echo $branch_name; ?></h1>
                                <p class="lead mb-0"><?php echo $servicing; ?></p>
                                <div class="appointment">
                                    <div class="aftrline1">
                                        <a href="<?php echo $servicing_link; ?>">Learn More</a>
                                    </div>
                                    <img src="<?php bloginfo('template_url'); ?>/img/line.png">
                                </div>
                            </a>
                        </div>
                    </div>
                      <?php $i++; endwhile; ?>    
                <?php endif; ?>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-10 col-sm-12 mx-auto">
                <p><?php the_field('where_we_are_paragraph'); ?></p>
            </div>
        </div>                
    </div>
</section>



<!-- Testimonials -->
<section class="testimonials text-center">
    <div class="container">
        <h1>Who We Lend To<br> <img src="<?php bloginfo('template_url'); ?>/img/line2.png"> </h1>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <p>We serve the following customer segments:</p>
                <div class="row">
                    <?php if( have_rows('we_land_to') ): ?>
               
            <?php $i =0; while( have_rows('we_land_to') ): the_row();  
                    $segments_name = get_sub_field('segments_name');
                    $segments_icon = get_sub_field('segments_icon');
                    $segments_link = get_sub_field('segments_link');
                 ?>   
                    <div class="col-lg-4 col-md-4">
                        <div class="testimonial-item mx-auto mb-0 mb-lg-0">
                            <a href="<?php echo $segments_link; ?>">
                                <img class="img-fluid" src="<?php echo $segments_icon['url']; ?>">
                                <h3><?php echo $segments_name; ?></h3>
                            </a>
                        </div>
                    </div>
                     <?php $i++; endwhile; ?>    
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="queries-section text-center">           
    <div class="container">
        <h1>Customers Queries <br> <img src="<?php bloginfo('template_url'); ?>/img/line2.png"> </h1>
        <div class="row">
            <div class="col-md-12 align-self-center">
                <a href="<?php bloginfo('url'); ?>/new-customer"><button class="customer-btn">New Customers</button> </a>                       
                <a href="<?php bloginfo('url'); ?>/existing-customer"><button class="customer-btn" style="margin-right: 0px;">Existing Customers</button></a>
            </div>
        </div>
    </div>
</section>



<?php
get_footer();
