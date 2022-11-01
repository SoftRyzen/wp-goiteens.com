<section class="section questions">
  <div class="container ">
    <h2 class="section-title text-accent "><?php the_field('questions_title');?></h2>
    <p class="questions__undertitle"><?php the_field('questions_text');?></p>
	<?php $header = get_field('header', 'option');?>
    <a class="link questions__link" href="tel:<?php echo "{$header['phone_href']}"; ?>"><?php echo "{$header['phone']}"; ?></a>

  </div>
</section>