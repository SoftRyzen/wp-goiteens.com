<?php
/*
Template Name: Blog Page
@package GoITeens
*/
get_header(); 
?>
<?php get_template_part('template-parts/main-header'); ?>

<div class="container">
    <main id="primary" class="site-main">
        <section class="section archive">
            <?php if (have_posts()) : ?>
             
                    <span class="text-label title__label text-center">будь у темі</span>
                    <h1 class="title section__title text-center"><?php single_post_title(); ?></h1>
			
			<?php  get_template_part( 'template-parts/search-blog-forms') ;?>
			
            <?php 
                $cat = get_cat_ID('main-blog-article'); 
                $args = ['category__in' => $cat];
			    $query = new WP_Query($args);
		    	$skip = false;
                $post_id_excluded = array(0);
			    if(!$query->have_posts()){
                    $args = ['posts_per_page' => 1, 'orderby' => 'date'];
		        	$skip =true;
		        	$query = new WP_Query($args);
                }
                
                while ($query->have_posts()){
                    $query->the_post();
                    array_push($post_id_excluded, $query->post->ID); 
                ?>
			        <div class="archive__main-post">
                        <?php get_template_part('template-parts/content-post', get_post_type()); ?>
			        </div>
                <?php } ?>
                <?php wp_reset_postdata(); ?>
			
                <ul class="list grid archive__list">
                    <?php 
                        $cat = get_cat_ID('main-blog-article');
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = array(
                            'category__not_in' => $cat,
                            'order_by' => 'date',
                            'posts_per_page' => 9,
                            'paged' => $paged,
                            'post__not_in' => $post_id_excluded
                        );
                        $ar_query = new WP_Query($args);
                        while ($ar_query->have_posts()):
                        $ar_query->the_post();
					    $match = false;
                        foreach (get_the_category() as $cat){
                            if ($cat->name == 'main-blog-article'){
                                $match = true;
                            }
                        }
                        ?>
                            <li class="archive__item grid__item ">
                                <?php get_template_part('template-parts/content-post', get_post_type()); ?>
								
                            </li>
                        <?php endwhile; ?>



                <?php else : ?>
                    <?php get_template_part('template-parts/content', 'none'); ?>
                <?php endif; ?>
                </ul>
                <div class="pagination">
                        <?php  echo paginate_links( array(
                            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                            'total'        => $ar_query->max_num_pages,
                            'current'      => max( 1, get_query_var( 'paged' ) ),
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'plain',
                            'end_size'     => 2,
                            'mid_size'     => 1,
                            'prev_next'    => true,
                            'prev_text'    => '<',
                            'next_text'    => '>',
                            'add_args'     => false,
                            'add_fragment' => '',
                            ) );
                            wp_reset_postdata(); 
                        ?>
                    </div>
        </section>
		<section>
			<?php get_template_part('template-parts/subscribe-form'); ?>
		</section>
    </main><!-- #main -->
</div>
<?php get_template_part('template-parts/main-footer'); ?>
<?php
get_footer();
