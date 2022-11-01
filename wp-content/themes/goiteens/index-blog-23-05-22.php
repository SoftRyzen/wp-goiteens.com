<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GoITeens
 */

get_header();
 ?>
<!--  <?php var_dump(is_front_page())
;?> -->
<!-- <?php
$script = $_SERVER['SCRIPT_NAME'];
echo $script;
?>

<?php
$params = $_SERVER['QUERY_STRING'];
echo $params;
?>

<?php
$hostame = $_SERVER['HTTP_HOST'];
echo $hostame;
?> -->


<?php get_template_part('template-parts/main-header'); ?>
<div class="container">
    <main id="primary" class="site-main">
        <section class="section archive">
            <?php if (have_posts()) : ?>
                <?php if (is_home() && !is_front_page()) : ?>
                    <span class="text-label title__label text-center">будь у темі</span>
                    <h1 class="title section__title text-center"><?php single_post_title(); ?></h1>
			<?php ;?>
                <?php endif; ?>
		<form action="<?php bloginfo( 'url' ); ?>" method="get">
<input  type="text" name="s" placeholder="Пошук" value="<?php if(!empty($_GET['s'])){echo $_GET['s'];}?>"/>
<input type="submit" value="Знайти"/>
</form>
			<?php echo do_shortcode( '[searchandfilter fields="category"  submit_label="Фільтрувати"]' ); ?>
			
                <?php $cat = get_cat_ID('main-blog-article'); ?>
                <?php $args = ['category__in' => $cat]; ?>
			    <?php $query = new WP_Query($args); ?>
		    	<?php $skip = false; ?>
			    <?php if(!$query->have_posts()): ?>
                    <?php $args = ['posts_per_page' => 1, 'orderby' => 'date']; ?>
		        	<?php $skip =true; ?>
		        	
		        	<?php $query = new WP_Query($args); ?>
			    <?php endif ?>
                
                <?php while ($query->have_posts()) : ?>
                    <?php $query->the_post(); ?>
			<div class="archive__main-post">
                    <?php get_template_part('template-parts/content-post', get_post_type()); ?>
			</div>
                <?php endwhile ?>
                <?php wp_reset_postdata(); ?>
			
                <ul class="list grid archive__list">
                    <?php $cat = get_cat_ID('main-blog-article'); ?>
                    <?php $args = $cat ? ['category__not_in ' => $cat] : ['orderby' => 'date'] ; ?>
                    <?php $query = new WP_Query($args);
                    ?> 
                    <?php while ($query->have_posts()) : ?>
                        <?php $query->the_post(); ?>
					<?php $match = false; ?>
                        <?php foreach (get_the_category() as $cat) : ?>
                            <?php if ($cat->name == 'main-blog-article') : ?>
                                <?php $match = true; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        <?php if (!$match && !$skip) : ?>
                            <li class="archive__item grid__item ">
                                <?php get_template_part('template-parts/content-post', get_post_type()); ?>
								
                            </li>
                        <?php endif ?>
                        <?php $skip = false; ?>

                    <?php endwhile ?>
                    <?php the_posts_navigation(); ?>
                <?php else : ?>
                    <?php get_template_part('template-parts/content', 'none'); ?>
                <?php endif; ?>
                </ul>
        </section>
		<section>
			<?php get_template_part('template-parts/subscribe-form'); ?>
		</section>
    </main><!-- #main -->
</div>
<?php get_template_part('template-parts/main-footer'); ?>
<?php
get_footer();
