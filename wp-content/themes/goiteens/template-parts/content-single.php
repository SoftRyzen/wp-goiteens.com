<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GoITeens
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	    <ul class="list item-info">
            <li>
				      
			    <?php foreach (get_the_category() as $cat) : ?>
                    <?php if ($cat->slug != 'main-blog-article') : ?>
			 <a href="<?php echo get_category_link($cat) ;?>" class="link">
            <span class="category">
                <svg class="icon" width="16" height="16">
                    <use href="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-sprite.svg#icon-doc"></use>
                </svg>

			
                        <?php echo $cat->name ?> 
				
  </span>
				   </a>
                    <?php endif ?>
                <?php endforeach ?>
            </li>
        </ul>
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="title entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="item-title entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<ul class="list item-info">
                <li>
                  <svg class="icon" width="16" height="16">
                    <use href="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-sprite.svg#icon-calendar"></use>
                  </svg>
                  <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                              <?php echo get_the_date(); ?>
                              </time>
                </li>
                <li>
                  <svg class="icon" width="16" height="16">
                    <use href="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-sprite.svg#icon-clock"></use>
                  </svg>
                   <span><?php echo gp_read_time(); ?> хв</span>
                </li>
              </ul>
		<?php endif; ?>
	</header><!-- .entry-header -->


	<div class="entry-content">
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
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->