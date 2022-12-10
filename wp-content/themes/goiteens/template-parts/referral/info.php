<section class="section info">
  <div class="info-awards">
    <div class="container">
		<ul class="list grid info-awards-list">
		 <?php
		$awards_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'awards',
			'category_name'	   => 'referral',
			'suppress_filters' => false
		);
		$awards_list = get_posts( $awards_section );

		foreach ( $awards_list as $item ) {
			$result = '';
			setup_postdata( $item );
			?>
        <li class="grid__item info-awards-item">
			<span class="info-awards-img">
          <picture>
            <source srcset="
                <?php echo get_template_directory_uri(); ?>/assets/images/referral/info/info-<?php echo $item->award_numb_id; ?>.webp    1x,
                <?php echo get_template_directory_uri(); ?>/assets/images/referral/info/info-<?php echo $item->award_numb_id; ?>@2x.webp 2x
              " type="image/webp" />
            <source srcset="./assets/images/referral/info/info-<?php echo $item->award_numb_id; ?>@2x.png 2x" type="image/png" />
            <img class="info-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/referral/info/info-<?php echo $item->award_numb_id; ?>.png"
              alt="<?php echo $item->award_img_alt; ?>-<?php echo $item->award_title; ?>" width="<?php echo $item->award_img_width; ?>" height="<?php echo $item->award_img_height; ?>" loading="lazy" />
          </picture>
				</span>
 <div class="info-awards-text">
          <h3 class="info-item-title"><?php echo $item->award_title; ?></h3>
          <p class="info-item-text"><?php echo $item->award_description; ?></p>
 </div>
        </li>
       <? } ?>
      </ul>

    </div>
  </div>
  <div class="info-counter">
    <div class="container">
	<?php $infoList= get_field('referral_info_list');
	  if($infoList): ?>
      <ul class="list grid info-counter-list">
        <?php foreach($infoList as $key=> $item): ?>
        <li class="grid__item info-counter-item">
          <h3 class="info-counter-title"><?php echo"{$item['number']}" ;?></h3>
          <p class="info-counter-descr"><?php echo"{$item['text']}" ;?></p>
        </li>
        <?php endforeach ;?>
      </ul>
	<?php endif ;?>
    </div>
  </div>
</section>