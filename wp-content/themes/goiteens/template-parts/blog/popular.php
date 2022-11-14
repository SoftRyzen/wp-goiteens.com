<?php
$popularPost = get_field('populars');
?>

<?php if( $popularPost ) { ?>
    <!-- Popular -->
    <section class="popular blogListPreload">
        <div class="container">
            <h2 class="popular-title"><?= _e( 'Популярні', 'goiteens' ) ?></h2>
            <?php
            $args = [
                'post__in' => $popularPost,
            ];
            $query = new WP_Query( $args );
            ?>
            <ul class="popular-list blogListContainer">
                <?php if ( $query->have_posts() ) { ?>
                    <?php while ( $query->have_posts() ) { $query->the_post(); ?>
                        <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                    <?php } ?>
                <?php } wp_reset_postdata(); ?>

            </ul>
            <buttom class="popular-button blogListBtn" type="button"><?= _e( 'Дивитися більше', 'goiteens' ) ?></buttom>
        </div>
    </section>
    <!-- End Popular -->
<?php } ?>
