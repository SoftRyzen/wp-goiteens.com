<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package GoITeens
 */

get_header();
?>
	<?php get_template_part( 'template-parts/main-header' ); ?>

    <div class="container main-container">
    	<main id="primary" class="site-main single-default">
    	    
    		<?php
    		while ( have_posts() ) :
    			the_post();
    
    			get_template_part( 'template-parts/content-single', get_post_type() );
    
				if(post_is_in_descendant_category(62, get_the_ID())){
				?>

				<div class="arrow-back-blog"><a href="/blog"><- Назад до блогу</a></div>

				<?php }

    			the_post_navigation(
    				array(
    					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'goiteens' ) . '</span> <span class="nav-title">%title</span>',
    					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'goiteens' ) . '</span> <span class="nav-title">%title</span>',
    				)
    			);
    
    		endwhile; // End of the loop.
    		?>
      
    	</main><!-- #main -->
    
        <?php get_sidebar(); ?>
    
      </div>
    <?php get_template_part( 'template-parts/main-footer' ); ?>
<?php get_footer();
