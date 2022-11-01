<section class="section questions">
  <div class="container questions-cont">
    <h2 class="section__title questions__title text-white"><?php the_field('questions_title');?></h2>
    <p class="block__title questions-undertitle"><?php the_field('questions_description');?></p>
	 <?php $phoneList = get_field('phone_list', 'option');
        if( $phoneList ): ?>
            <?php foreach ($phoneList as $item): ?>
              <a class="link questions-link" href="tel:<?php echo "{$item['phone_href']}"; ?>"><?php echo "{$item['phone_text']}"; ?></a>
              <?php endforeach; ?>
			 <?php endif; ?>	
  	<?php $questionMail = get_field('question_mail'); if($questionMail):?>
	  <p class="block__title questions-undertitle questions-undertitle__mail">
		  <?php echo $questionMail?>
	  </p>
	  <a class="link questions-link questions-link__mail" href="mailto:kontakt@goiteens.global">kontakt@goiteens.global</a> <?php endif ;?>
  </div>
</section>
