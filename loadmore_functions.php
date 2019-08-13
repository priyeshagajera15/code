<?php
   

 //test code in function.php
add_action('wp_ajax_load_posts_by_ajax', 'load_more');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_more');

function load_more() {
	check_ajax_referer('load_more_posts', 'security');
	$paged = $_POST['page'];
	 $posts_offset = $_POST['posts_offset'];
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => '2',
		'paged' => $paged,
		'offset'=> $posts_offset ,
	);
	$my_posts = new WP_Query( $args );
	 
	if ( $my_posts->have_posts() ) :
		?>
		<?php while ( $my_posts->have_posts() ) : $my_posts->the_post() 
			
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
					
	<?php endwhile;	endif;

	$posts_count=wp_count_posts()->publish;
// 	print_r($posts_count - ($posts_offset + 2));
 if ($posts_count - ($posts_offset + 2) <= 0) { ?>
<script>function hideLoadMore(){jQuery(".load_more").hide();}</script>
    <?php }
	
	wp_die();
} 


add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );

function sdt_remove_ver_css_js( $src, $handle ) 
{
    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}