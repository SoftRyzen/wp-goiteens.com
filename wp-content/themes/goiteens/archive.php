<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GoITeens
 */

get_header();
?>
	<?php get_template_part( 'template-parts/main-header' ); ?>
    <div class="container">
    	<main id="primary" class="site-main">
            
    		<?php if ( have_posts() ) : ?>
     <section class="section archive">
<!--     			<header class="page-header"> -->
    				<?php
    				the_archive_title( '<h1 class="page-title test">', '</h1>' );
    				the_archive_description( '<div class="archive-description">', '</div>' );
    				?>
<!--     			</header> -->
		 
<?php  get_template_part( 'template-parts/search-blog-forms') ;?>
		 
      <ul class="list grid archive__list">
    			<?php
    			/* Start the Loop */
    			while ( have_posts() ) :
    				the_post();?>
    
    				
<!--     				 Include the Post-Type-specific template for the content. -->
<!--     				 If you want to override this in a child theme, then include a file -->
<!--     				 called content-___.php (where ___ is the Post Type name) and that will be used instead. -->
    				 
		    <li class="archive__item grid__item ">
    			<?php	get_template_part( 'template-parts/content', get_post_type() );?>
          </li>
    		<?php	endwhile;
    
    			the_posts_navigation();
    
    		else :
    
    			get_template_part( 'template-parts/content', 'none' );
    
    		endif;
    		?>
            </ul>
			</section>
    	</main><!-- #main -->
    
    <?php
    get_sidebar(); ?>
    
     </div>
  <?php get_template_part( 'template-parts/main-footer' ); ?>
<?php get_footer();
