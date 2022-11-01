<?php
/**
 * Шаблон обычной страницы вакансии (single-vacancies-page.php)
 * @package WordPress

 */
get_header(); // подключаем header.php ?>
<?php get_template_part( 'template-parts/main-header' ); ?>
<main >
	<section class="single-vacancy">
        <div class="container main-container">
        		<div class="single__content">
        	        <h1 class="title"> <?php the_title(); ?> </h1>
        	        <div class="content single__overview">
        			    <?php the_content(); // контент ?>
        			</div>
        			<div class="single__contacts ">
        			    <p class="text-bold"><?php the_field('single_vac_contact_title', 'option'); ?></p>
        			    <p><?php the_field('single_vac_contact_link_text', 'option'); ?> <a class="link text-accent" href="mailto:<?php echo get_field('contact_mail', 'option'); ?>"><?php echo get_field('contact_mail', 'option'); ?></a>.</p>
        			    <p><?php the_field('single_vac_contact_text', 'option'); ?></p>
        			</div>
    		    </div>
		    <div class="vacancy-form-wrap" data-current="<?php echo $post->post_title; ?>">		
			 <?php echo do_shortcode('[contact-form-7 id="3322" title="Контактна форма 1" html_class="modal-form vacancies-form"]'); ?>
			 <?php echo do_shortcode('[contact-form-7 id="3360" title="Порадити кандидата" html_class="modal-form vacancies-form"]'); ?> 	
			</div>
			 <aside class="widget-area">
    		    <h2 class="title vacancy__sidebar-title">Також ми шукаємо:</h2>
    		    <ul class="list vacancy__sidebar-list">
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
                    <li class="item vacancy__sidebar-item" id="<?= $idName . $idCount ?>">
                        <a class="link vacancy__sidebar-link" href="<?php echo get_permalink($item->ID); ?>" target="_blank">
                           <?php echo $item->post_title; ?>
                        </a>
                    </li>
    			    <? $idCount ++; ?>
    		        <? } ?>
                </ul>	
              </aside>
		</div>
		   
	</section>
</main>
<?php get_template_part( 'template-parts/main-footer' ); ?>
<script>
	const vacanciesData = document.querySelectorAll('input[name="data-vacancy"]') ;
	const curentVacancy = document.querySelector('[data-current]');
	
	vacanciesData.forEach(vacancy =>{
		vacancy.value = curentVacancy.dataset.current
	})
	
</script>
<?php get_footer(); ?>


