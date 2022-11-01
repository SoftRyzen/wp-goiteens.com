<section class="section why">
  <div class="container">
    <div class="side-left">
      <h2 class="section-title"><?php the_field('why_title'); ?></h2>
      <p class="description"><?php the_field('why_description'); ?></p>
				<?php 
		if(get_the_ID() == 6489){
			$imgSrc = "fe-start";
		}elseif(get_the_ID() == 6850){
			$imgSrc = "design-start";
		}else{
			$imgSrc ="python-start";
		}
		;?>
      <picture>
        <source
          srcset="
            <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>/why/smart-boy_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>/why/smart-boy_lg@2x.webp 2x
          "
          type="image/webp"
          media="(min-width: 1280px)"
        />
        <source
          srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>/why/smart-boy_lg.png    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>/why/smart-boy_lg@2x.png 2x
          "
          type="image/png"
          media="(min-width: 1280px)"
        />

        <img class="why-img" src="  <?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>/why/smart-boy_lg.png" alt="<?php the_field('why_img_alt'); ?>" loading="lazy" width="<?php the_field('why_img_width'); ?>" height="<?php the_field('why_img_height'); ?>" />
      </picture>
    </div>
    <div class="side-right">
		<?php $whyList = get_field('why_list');
		if( $whyList ): ?> 
      <ul class="list card-set">
       	<?php foreach( $whyList as $item ): ?>	
        <li class="item card-set-item">
          <p class="item-title text-accent"><?php echo "{$item['title']}"; ?></p>
          <p><?php echo "{$item['description']}"; ?></p>
        </li>
       <?php endforeach; ?>
      </ul>
		<?php endif; ?>
    </div>
  </div>
</section>
