<?php
/*
Template Name: Blog Archive Page
*/
get_header(); 
?>
	<?php get_template_part( 'template-parts/main-header' ); ?>
	
    <div class="container">
    	<main id="primary" class="site-main 1">
    	    <?php if ( have_posts() ) : // если есть посты
	while ( have_posts() ) : the_post(); // то инициализируем каждый пост по порядку
		// выполняем код для каждого конкретного поста
		the_title( '<h2>', '</h2>' ); // например выводим заголовок
	endwhile;
else:
	echo 'В этой категории нет записей, вероятно.';
endif; ?>
            
    		<?php if ( have_posts() ) : ?>
    
    			<header class="page-header">
    				<?php
    				the_archive_title( '<h1 class="page-title">', '</h1>' );
    				the_archive_description( '<div class="archive-description">', '</div>' );
    				?>
    			</header><!-- .page-header -->
    
    			<?php
    			/* Start the Loop */
    			while ( have_posts() ) :
    				the_post();
    
    				/*
    				 * Include the Post-Type-specific template for the content.
    				 * If you want to override this in a child theme, then include a file
    				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
    				 */
    				get_template_part( 'template-parts/content', get_post_type() );
    
    			endwhile;
    
    			the_posts_navigation();
    
    		else :
    
    			get_template_part( 'template-parts/content', 'none' );
    
    		endif;
    		?>
           
    	</main><!-- #main -->
    
    <?php
    get_sidebar(); ?>
    
     </div>


    <?php get_template_part( 'template-parts/main-footer' ); ?>

<?php get_footer();