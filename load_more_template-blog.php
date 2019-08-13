<?php
/**
 *   Theme: techhive
 *   The full page width template.
 *   This is the template that displays all pages by default.
 *   Template Name: blog template
 *   @package techhive
 *   @version techhive 1.1
 */
get_header();
?>
 
<div class="entry-content home-blog">
	<div class="container">
         <div class="row" >
 			<div class="col-md-12">
            	<div class="title text-center">
                	<h2>Blog</h2>
                </div>
            </div>
			<?php
				$args     = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => '2',
					'paged' => 1,
				);
				$my_posts = new WP_Query($args);

				if ($my_posts->have_posts()):
			?>
  			<div class="my_post">  
				<?php
					while ($my_posts->have_posts()):
					$my_posts->the_post();
				?>
				<div class="col-md-6">
 					<div class="blog">  
                		<div class="blogimage">
						<?php
							if (has_post_thumbnail()) {?>
							<a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail(); ?></a>
				   		<?php } ?>
        			</div>
                    <div class="blogcontent">
                    	<h4><a href="<?php the_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a></h4>
                        <span class="date"><?php  the_date();?></span>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"></a> 
						<a href="<?php the_permalink(); ?>"><?php the_excerpt(); // or the_content(); for full post content ?></a> 
                                              
                    </div>
<!--                         <div class="blog_footer">
                         <span class="like"><i class="fa fa-heart-o" aria-hidden="true"></i>  &nbsp; likes </span>
                          <span class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i> &nbsp;
                     <?php
							$comments_count = wp_count_comments();
							echo $comments_count->approved;
					?>   Comments </span>
                        </div> -->
              	</div>
  			</div>
			<?php	
				endwhile;
			?>
      	</div>
	</div>        
    <?php
		endif;
	?>

		<div class="load_more"><a>Load More...</a></div>
  	</div>
</div>


<?php
get_footer();
?>

<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var page = 2;
	var posts_offset = 2;
	jQuery(function($) {
    	$('body').on('click', '.load_more', function() {
        	var data = {
            	'action': 'load_posts_by_ajax',
            	'page': page,
				'posts_offset': posts_offset,
            	'security': '<?php
					echo wp_create_nonce("load_more_posts");
				?>'
		};
        $.post(ajaxurl, data, function(response) {
            $('.my_post').append(response);
            page++;
			 posts_offset += 2;
			 if(hideLoadMore) { 
        hideLoadMore(); 
    }
        });
    });
});
</script>
