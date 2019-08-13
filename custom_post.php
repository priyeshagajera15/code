Template Header/Bloginfo Tags
* <?php bloginfo('url'); ?>  – Your site’s URL
*  <?php bloginfo('stylesheet_url'); ?> – Link to your themes’s stylesheet file
* <?php bloginfo('template_url'); ?> – Location of your site’s theme file
* <?php site_url(); ?> – The root URL for your site
https://premium.wpmudev.org/blog/developer-super-cheat-sheet/
creating the template shortcode in wordpress
function portfolio_shortcode() {
                  ob_start();
                  get_template_part('portfolios');
                  return ob_get_clean();   
        } 
add_shortcode( 'portfolio', 'portfolio_shortcode'); 
	displaying the all post and featured image and  link to it


        
<?php
               $loop = new WP_Query(array('post_type' => 'post', 'posts_per_page' => -1));
               $count = 0;
               
                if ($loop) :
                           while ($loop->have_posts()) : $loop->the_post();
              ?>
       <ul class="nav">
           <li><a href="<?php the_permalink() ?>"> <?php the_title(); ?> </a></li>
           <li><a href="<?php the_permalink() ?>"> <?php the_post_thumbnail(); ?> </a></li>
       </ul>
       <?php        
           endwhile;
           else: ?><div>no post images</div><?php
       endif;
	        ?>                                                             




Create Custom Page


<?php
/*
Template Name: Name of Template
*/
?>
	wp image path


<img src="<?php bloginfo('template_url'); ?>/asset/img/img.jpg">
	get Template Part


<?php get_template_part( 'foo','bar' ); ?> 
<?php echo get_home_url(); ?> --- home url

<?php echo do_shortcode('[CONTACT-US-FORM]'); ?>
 
include -----  ../wp-content/themes/your-theme-slug/foo-bar.php

	Trimming post content


<? php echo wp_trim_words( get_the_content(), 40, '...' );  ?>
	

add image size thumbnail


<? php add_image_size( 'wordpress-thumbnail', 200, 200, array( 'center', 'center' ) ); ?>
	Create Custom Post

<?php
add_action('init', 'project_custom_init_Blog');  

function project_custom_init_Blog()
{
 $labels = array(
   'name' => _x('Blog', 'post type general name'),
   'singular_name' => _x('Blog', 'post type singular name'),
   'add_new' => _x('Add New', 'Blog'),
   'add_new_item' => __('Add New Blog'),
   'edit_item' => __('Edit Blog'),
   'new_item' => __('New Blog'),
   'view_item' => __('View Blog'),
   'search_items' => __('Search Blog'),
   'not_found' =>  __('No Blog found'),
   'not_found_in_trash' => __('No Blog found in Trash'),
   'parent_item_colon' => '',
   'menu_name' => 'Blog'

 );
  
$args = array(
   'labels' => $labels,
   'public' => true,
   'publicly_queryable' => true,
   'show_ui' => true,
   'show_in_menu' => true,
   'query_var' => true,
   'rewrite' => true,
   'capability_type' => 'post',
   'has_archive' => true,
   'hierarchical' => false,
   'menu_position' => null,
   'supports' => array('title','editor','author','thumbnail','comments')
 );
 // The following is the main step where we register the post.
 register_post_type('blog',$args);
  
 // Initialize New Taxonomy Labels
 $labels = array(
   'name' => _x( 'Category', 'taxonomy general name' ),
   'singular_name' => _x( 'Category', 'taxonomy singular name' ),
   'search_items' =>  __( 'Search Types' ),
   'all_items' => __( 'All Category' ),
   'parent_item' => __( 'Parent Category' ),
   'parent_item_colon' => __( 'Parent Category:' ),
   'edit_item' => __( 'Edit Category' ),
   'update_item' => __( 'Update Category' ),
   'add_new_item' => __( 'Add New Category' ),
   'new_item_name' => __( 'New Category Name' ),
 );
   // Custom taxonomy for Project Tags
   register_taxonomy('category_blog',array('blog'), array(
   'hierarchical' => true,
   'labels' => $labels,
   'show_ui' => true,
   'query_var' => true,
   'has_archive' => true,

   'rewrite' => array( 'slug' => 'blog-category' ),
 ));
  }
	



Custom logo upload
 <a href='<?php echo esc_url(home_url('/')); ?>' title='<?php echo esc_attr(get_bloginfo('name', 'display')); ?>' rel='home'>
                               <img src='<?php echo esc_url(get_theme_mod('m1_logo')); ?>' alt='<?php echo esc_attr(get_bloginfo('name', 'display')); ?>'>
                           </a>

Function.php

function m1_customize_register( $wp_customize ) {
   $wp_customize->add_setting( 'm1_logo' ); // Add setting for logo uploader
        
   // Add control for logo uploader (actual uploader)
   $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'm1_logo', array(
       'label'    => __( 'Upload Logo (replaces text)', 'm1' ),
       'section'  => 'title_tagline',
       'settings' => 'm1_logo',
   ) ) );
}
	Add Span tag in Text Editor
add_action( 'customize_register', 'm1_customize_register' );

// for support i tag in wp text block

function override_mce_options($initArray) {

   $opts = '*[*]';

   $initArray['valid_elements'] = $opts;

   $initArray['extended_valid_elements'] = $opts;

   return $initArray;

}

add_filter('tiny_mce_before_init', 'override_mce_options');
	

Hide Admin Bar 
// hide admin bar


add_filter('show_admin_bar', '__return_false');
	





Add Script in function.php



add_action('wp_footer','addmyScript');

function addmyScript() {
   ?>
<script> 
 jQuery(document).ready(function() { 
 });
</script>
<?php 
}

function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);

      if (count($excerpt) >= $limit) {
          array_pop($excerpt);
          $excerpt = implode(" ", $excerpt) . '...';
      } else {
          $excerpt = implode(" ", $excerpt);
      }

      $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);

      return $excerpt;
}

function content($limit) {
    $content = explode(' ', get_the_content(), $limit);

    if (count($content) >= $limit) {
        array_pop($content);
        $content = implode(" ", $content) . '...';
    } else {
        $content = implode(" ", $content);
    }

    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content); 
    $content = str_replace(']]>', ']]&gt;', $content);

    return $content;
}

then in your template code you just use..

<?php echo excerpt(25); ?>

/* Wordpress Loop  */
<?php
                    $args = array(
                        'post_type' => 'post'
                    );

                    $post_query = new WP_Query($args);
                    if ($post_query->have_posts()) {
                        while ($post_query->have_posts()) {
                            $post_query->the_post();
                            ?>
                            <div class="card news-section">
                                <a href="<?php the_permalink() ?>">
                                    <?php if (has_post_thumbnail($post->ID)): ?>
                                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
                                        <img class="thumbnail_img" src="<?php echo $image[0]; ?>">
                                    <?php endif; ?>
                                    <div class="data">
                                        <h3><?php the_title(); ?></h3>
                                        <p class="time"><?php the_date(); ?>  |  <?php the_author(); ?></p>
                                        <p><?php echo excerpt(25); ?></p>
                                    </div>
                                </a>
                            </div>
                           
                            <?php
                        }
                    }
                    ?>
/* thumbnail Attachedment url */
<?php
$post_thumbnail_id = get_post_thumbnail_id($post->ID);
$post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
?>
<a href="<?php echo $post_thumbnail_url; ?>">
<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>

	<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>

<?php endif; ?>
</a>
<a href="<?php echo $post_thumbnail_url; ?>">

/* create custom menu location */
function wpb_custom_new_menu() {
  register_nav_menus(
    array(
      'topbar-menu' => __( 'Topbar Menu' ),
      'footer-menu' => __( 'Footer Menu' )
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );

// Custom Thumbnail size 
add_image_size( 'product-thumbnail', 300, 300, true );
	
<?php echo get_the_post_thumbnail( $product->get_ID(), 'product-thumbnail' ); ?>
	
	
