<section class="section advantages">
    <div class="container">
        <div class="advantages__descr">
            <h2 class="section-title"><?php the_field('referral_advantages_title'); ?></h2>
            <p class="advantages__label"><?php the_field('referral_advantages_label'); ?></p>
        </div>
		<?php $advantagesList= get_field('referral_advantages_list');
	  if($advantagesList): ?>
        <ul class="advantages__list list grid">
            <?php foreach($advantagesList as $key=> $item): ?>
            <li class="advantages__item grid__item">
                <h3 class="advantages__title "><?php echo"{$item['title']}" ;?></h3>
                <p class="advantages__text"><?php echo"{$item['text']}" ;?></p>
            </li>
            <?php endforeach ;?>
        </ul>
		<?php endif ;?>
    </div>
</section>