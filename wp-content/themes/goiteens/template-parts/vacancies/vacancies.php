<section class="section vacancy">
  <div class="container">		
    <div class="vacancy__container grid">
		
			<?php $vacancies_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'vacancies',
// 			'category_name'    => 'vacancies',
			'suppress_filters' => false
		);
		$vacancies_list = get_posts( $vacancies_section );
		$idCount          = 0;
		$idName           = "vacancy__item-";
		foreach ( $vacancies_list as $item ) {
			$result = '';
			setup_postdata( $item );
		?>
		<div class="vacancy__item grid__item" id="<?php echo ($idName . $idCount) ?>">
    
		<a class="link title" href="<?php echo get_permalink($item->ID); ?>" target="_blank" rel="noopener noreferrer nofollow">
          <?php echo $item->post_title; ?> 
		</a>
        <p class="text__description "><?php echo get_the_excerpt($item->ID); ?></p>
    
      <div class="vacancy__box-btn">
			<a href="<?php echo get_permalink($item->ID); ?>"  class="main-btn  main-btn--link" target="_blank" rel="noopener noreferrer nofollow" ><?php the_field('vacancies_button_more');?></a>
			<button  type="button" class="main-btn" data-modal-open="resume"  data-vacancy="<?php echo $item->post_title; ?>"><?php the_field('vacancies_button_send');?></button>
			<button  type="button" class="main-btn" data-modal-open="candidate" data-vacancy="<?php echo $item->post_title; ?>"><?php the_field('vacancies_button_recommend');?></button>
      </div>
		            </div>
			<? $idCount ++; ?>	
 <? } ?>
    </div>

  </div>
</section>