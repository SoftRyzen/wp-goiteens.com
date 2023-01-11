<?php

?>
<!-- Search Result -->
<section class="popular blog__search-result blogListPreload">
    <div class="container">
        <h2 class="popular-title blog__search-result-title"><?= _e( 'Пошук:', 'goiteens' ) ?> <?= $_GET['search'] ?></h2>

        <?php
        $args = array(
            'post_type' => 'post',
            's' => $_GET['search'],
            'post_status' => 'publish',
            'orderby'     => 'title',
            'order'       => 'ASC'
        );
        $query = new WP_Query($args);
        ?>
        <?php if( $query->have_posts() ) { ?>
            <ul class="popular-list blogListContainer">

                <?php while ( $query->have_posts() ) { $query->the_post(); ?>
                    <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                <?php } ?>

            </ul>
        <?php }else{ ?>

            <?php _e( 'Нічого не знайдено', 'goiteens' ) ?>

        <?php } wp_reset_postdata(); ?>
    </div>
</section>
<!-- End Search Result -->
