<section class="section modules" id="modules">
  <h2 class="section__title modules__title"><?php the_field('modules_title'); ?></h2>
  <div class="container">
    <div class="modules-slider-pagination modules__pagination">
		<?php $pagination = get_field('pagination');
			if( $pagination ): ?> 
				<?php foreach( $pagination as $item ): ?>
      			<p class="modules__pagination-text"><?php echo "{$item['text']}"; ?></p>
			<?php endforeach; ?>
		<?php endif; ?>
    
    </div>
  </div>
  <div class="slider modules-slider-js">
	  <?php $blocksList = get_field('blocks_list');
		if( $blocksList ): ?> 
	  <?php foreach( $blocksList as $item ): ?>
	  
    <div class="slider-item">
      <div class="modules__wrapper">
        <div class="container">
          <ul class="list modules__yellow-list">
            <li class="section__subtitle modules__yellow-title"><?php echo "{$item['blocks_title']}"; ?></li>

            <li>
              <img
                class="modules__stars-img"
                src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/modules/<?php echo "{$item['img_star']}"; ?>.svg"
                alt="<?php echo "{$item['img_alt']}"; ?>"
                width="88"
                height="24"
                loading="lazy"
              />
            </li>

            <li class="modules__item-duration">
              <p class="text-bold modules__duration"><?php the_field('block_duration'); ?></p>
              <p class="text-accent text-bold"><?php echo "{$item['duration']}"; ?></p>
            </li>

            <li>
				<?php foreach( $item['blocks_description_list'] as $item ): ?>
				<ul class="list">					
					<li>
						<p><?php echo "{$item['text']}"; ?></p>
					</li>  						
				</ul>
				 <?php endforeach; ?>
            </li>
          </ul>
        </div>
      </div>
		
		<?php foreach( $item['blocks_lists_items'] as $item1 ): ?>

      <div class="modules__list-wrapper">
        <div class="container">
          <ul class="list grid modules__common-list modules__main-list">
<!--             {% for item in list.item %} -->
            <li class="grid__item modules__list-item">
<!--               {% if item.label %} -->
<!--               <p class="text-accent text-bold modules__label"><?php echo "{$item['lists_label']}"; ?></p> -->
<!--               {% endif %} -->

              <h3><?php echo "{$item1['lists_title']}"; ?></h3>
<!--               {% if item.description %} -->
<!--               <p class="modules__description">{{item.description}}</p> -->
<!--               {% endif %} {% if item.logos %} -->
<!--               <ul class="list modules__common-list modules__logos-list">
                {% for logo in item.logos %}
                <li class="modules__logos-item">
                  <img
                    class=""
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/frontend-junior/modules/{{logo.id}}.png"
                    alt="{{logo.id}}"
                    width="{{logo.logo_width}}"
                    height="{{logo.logo_height}}"
                    loading="lazy"
                  />
                </li>

                {% endfor %}
              </ul> -->
<!--               {% endif %} -->
            </li>
<!--             {% endfor %} -->
          </ul>
        </div>
      </div>
	<?php endforeach; ?>
    </div>
  	<?php endforeach; ?>
	<?php endif; ?>
  </div>
</section>
