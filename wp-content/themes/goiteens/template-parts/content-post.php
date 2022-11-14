<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GoITeens
 */

?>


<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <a href="<?php echo get_permalink(); ?>">

        <!-- image -->
        <?php if (has_post_thumbnail()) {
            the_post_thumbnail('post-thumbnail', ['class' => 'publication-image']);
        } else { ?>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog/Group_126.png" alt="<?= get_the_title() ?>" />
        <?php } ?>
        <!-- end image -->

        <?php
        $cats = wp_get_post_categories(get_the_ID(), ['fields' => 'all']);
        ?>
        <?php if( $cats ) { ?>
            <!-- label -->
            <p class="publication-label">
                <?php foreach ( $cats as $cat ) { ?>
                    <?= $cat->name ?>
                <?php } ?>
            </p>
            <!-- end label -->
        <?php } ?>

        <!-- description -->
        <div class="publication-description">

            <?php the_title('<h3 class="publication-description__title">', '</h3>'); ?>

            <?php if( has_excerpt() ) { ?>
                <p class="publication-description__text"><?= get_the_excerpt() ?></p>
            <?php } ?>

            <div class="publication-description__link"><?= _e( 'Читати далі', 'goiteens' ) ?> ›</div>

        </div>
        <!-- end description -->

    </a>
</li><!-- #post-<?php the_ID(); ?> -->
