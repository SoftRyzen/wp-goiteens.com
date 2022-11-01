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
    <div class="item__img-wrap">
        <a href="<?php echo get_permalink(); ?>" class="link">
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


          
            <?php if (has_post_thumbnail()) {
                the_post_thumbnail();
            } else { ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/Group_126.png" alt="" />
            <?php } ?>
        </a>
    </div>
    <?php the_title('<a class="link item__title archive__item-title"  href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a>'); ?>
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

    <?php the_excerpt(); ?>
    <a href="<?php echo get_permalink(); ?>" class="link readmore-link">
        Читати
        <svg class="icon" width="24" height="24">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/blog/blog-sprite.svg#icon-next-btn"></use>
        </svg>
    </a>
</article><!-- #post-<?php the_ID(); ?> -->