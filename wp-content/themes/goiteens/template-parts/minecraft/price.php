<section class="section price">   
	<div class="container">
			<?php $priceList = get_field("price_list");
			if($priceList):
			?>
		<ul class="list price__list">
      <?php foreach($priceList as $item):?>
		
      <li class="item price__item <? if( $item['price_active'] ): echo "{$item['price_active']}"; endif?>" tabindex=0 data-modal-open>
        <p class="price__duration"><?php echo "{$item["duration"]}";?></p>
        <svg width="100" height="2">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/images/minecraft/sprite.svg#soft-skills-line"></use>
        </svg>
        <p class="price__per-month"><?php echo "{$item["price__per_month"]}";?></p>
        <p class="price__benefit"><?php echo "{$item["price_benefit"]}";?></p>

		  <?php if($item["price__total"]):?>
        <p class="price__total"><?php echo "{$item["price__total"]}";?></p>
        <?php endif;?>
      </li>
			<?php endforeach ;?>
    </ul>
		<?php endif ;?>
		</div>
	</section>