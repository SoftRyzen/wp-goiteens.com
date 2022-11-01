<section class="section contact">
    <div class="container contact__line">
        <div class="contact__wrapper">
            <h2 class="contact__title section-title"><?php the_field('all_contact_title'); ?></h2>
            <div class="contact___descrWrap">
                <div class="contact__descr">
                    <p><?php the_field('all_contact_desription_first'); ?></p>
                    <p><?php the_field('all_contact_desription_second'); ?></p>
                </div>
                <div class="contact__registrWrap">
                    <p class="contact__registr"><?php the_field('all_contact_registrarion'); ?></p>
                    <div class="contact__btn">
						
		<?php $btnType= "button";
		$btnClass= "contact__btn";
		$btnText= get_field('all_registration_btn');
		  $btnData= "data-modal-open";
		?>
	 <?php get_template_part( 'template-parts/courses-all/components/btn', null, ['btnType' => $btnType, 'btnClass' => $btnClass, "btnData" => $btnData, "btnText" => $btnText ]  ); ?> 
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>