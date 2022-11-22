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

    <?php get_template_part( 'template-parts/blog/search'); ?>

    <!-- Title -->
    <section class="cat_title">

        <!-- container -->
        <div class="container">

            <?php the_archive_title( '<h1 class="offers-title">', '</h1>' ); ?>
            <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

        </div>
        <!-- end container -->

    </section>
    <!-- End Title -->

    <!-- Popular -->
    <section class="popular blog__grid">

        <!-- container -->
        <div class="container">

            <?php if( have_posts() ) { ?>

                <!-- list -->
                <ul class="blog__grid-list popular-list">

                    <?php while ( have_posts() ) { the_post(); ?>
                            <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                    <?php } ?>

                </ul>
                <!-- end list -->

            <?php }else{ ?>

                <?php _e( 'Нічого не знайдено', 'goiteens' ) ?>

            <?php } ?>
        </div>
        <!-- end container -->

    </section>
    <!-- End Popular -->

    <?php get_template_part( 'template-parts/blog/specials'); ?>

    <?php get_template_part( 'template-parts/main-footer' ); ?>

<?php get_footer();
