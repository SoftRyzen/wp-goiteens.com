<section class="section help">
  <div class="container help__wrapper">
    <h2 class="section__title help__title"><?php the_field('help_title'); ?></h2>
    <p class="block__title help__description"><?php the_field('help__description'); ?></p>
   
	  <?php  $btnText= get_field('free_btn');
		$btnStyle="help__btn main-btn--violet";
		$btnDataModal="data-modal-open"
		?>
	 <?php get_template_part( 'template-parts/itmarathon/components/btn', null, ['btnText' => $btnText, 'btnStyle' => $btnStyle, 'btnDataModal' => $btnDataModal ]  ); ?>
  </div>
</section>