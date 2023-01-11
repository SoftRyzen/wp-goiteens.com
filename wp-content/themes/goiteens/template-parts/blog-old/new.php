<?php

?>
<?php
$args = [
    'posts_per_page' => 3,
    'orderby' => 'date'
];
$newPost = new WP_Query($args);
if( $newPost->have_posts() ) {
    ?>
    <!-- New Post -->
    <section class="publication">
        <div class="container">

            <h2 class="publication-title"><?= _e( 'Нові публікації', 'goiteens' ) ?></h2>

            <ul class="publication-list">
                <?php while ($newPost->have_posts()) { $newPost->the_post(); ?>
                    <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                <?php } ?>
            </ul>

        </div>
    </section>
    <!-- End New Post -->
<?php } wp_reset_postdata(); ?>
