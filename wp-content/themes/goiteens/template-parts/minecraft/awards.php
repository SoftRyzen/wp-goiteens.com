<section class="section main-awards">
  <div class="container">
    <h2 class="section__title"><?php the_field('awards_title');?></h2>
    <p class="text-label"><?php the_field('awards_description');?></p>
  </div>
<?php get_template_part( 'template-parts/awards', get_post_type() ); ?>
</section>
