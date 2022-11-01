<section class="section questions">
	<?php $header = get_field('header', 'option'); ?>
  <div class="container ">
    <h2 class="section__title  text-white"><?php the_field('questions_title');?></h2>
    <p class="block__title questions__undertitle"><?php the_field('questions_text');?></p>
    <a class="link questions__link" href="tel:<?php echo "{$header['phone_href']}"; ?>"><?php echo "{$header['phone']}"; ?></a>
  </div>
</section>