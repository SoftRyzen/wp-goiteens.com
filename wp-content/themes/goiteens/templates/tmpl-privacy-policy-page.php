<?php
/*
Template Name: Privacy-policy Page
*/
get_header();
?>
<?php get_template_part( 'template-parts/main-header'  ); ?>

 <main class="polytic-page">
      <div class="container">
	<h1 class="title"><?php the_field('privacy_title'); ?></h1>
	<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'goiteens' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'goiteens' ),
				'after'  => '</div>',
			)
		);
		?> 		  		  		  		  
		 		 
      </div>
    </main>
<?php get_template_part( 'template-parts/main-footer'  ); ?>
<?php
get_footer();