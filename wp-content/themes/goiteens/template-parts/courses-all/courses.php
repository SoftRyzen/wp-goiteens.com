<section class="section courses">
    <div class="container">
        <h2 class="section-title"><?php the_field('courses_title'); ?></h2>
<?php $coursesList = get_field('courses_items');
		if( $coursesList ): ?>
        <ul class="courses__list list grid">
           <?php foreach($coursesList as $item ): ?>

            <li class="courses__item grid__item" data-courses="<?php echo "{$item['data_courses']}"; ?>">
                <div class="courses__content" data-img>
                    <div class="courses__descr">
                        <div class="courses__descrWrapper">
                            <p class="courses__age"><?php echo "{$item['age']}"; ?></p>
                            <h3 class="courses__title text-accent item-title"><?php echo "{$item['title']}"; ?></h3>
                        </div>
                        <p class="courses__text"><?php echo "{$item['description']}"; ?></p>
                         <?php if( $item['label'] ): ?>
                        <p class="courses__label"><?php echo "{$item['label']}" ; ?></p>
                         <?php endif; ?>	
                    </div>
                    <div class="courses__btnsWrapper">
						
						
		<?php $btnType= "button";
		$btnMoreClass= "courses__btn main-btn--violet";
		$btnClass= "courses__btn";				
		$btnMoreText= get_field('all_details_btn');
		$btnText= get_field('all_free_lesson');
		$btnMoreData= "data-show-more";
		$btnData= "data-modal-open"
		?>
	 <?php get_template_part( 'template-parts/courses-all/components/btn', null, ['btnType' => $btnType, 'btnClass' => $btnMoreClass, "btnData" => $btnMoreData, "btnText" => $btnMoreText ]  ); ?> 
     <?php get_template_part( 'template-parts/courses-all/components/btn', null, ['btnType' => $btnType, 'btnClass' => $btnClass, "btnData" => $btnData, "btnText" => $btnText ]  ); ?> 

                    </div>
                </div>

                <div class="courses__about is-hidden" data-more-text>
                    <p class="item-title courses__about-title"><?php the_field('program_title'); ?></p>
                    <ul class="list courses__about-list">
						 <?php foreach($item['program'] as $prog ): ?>
                        
                        <li class="courses__about-item">
                            <ul class="list courses__program-list">
                                
								<?php foreach($prog['item'] as $list ): ?>
                                <li class="courses__program-item">
                                    <?php if( $list['title'] ): ?>
                                    <h3
                                        class="<?php if( $list['icon_items'] ): ?>text-accent<?php else :?> courses__program-title <?php endif; ?>	">
                                         <?php echo "{$list['title']}" ; ?>
                                    </h3>
                                    <?php endif; ?>	
                                    <ul
                                        class="<?php if( $list['icon_items'] ): ?>list courses__icon-list <?php else :?> courses__text-list<?php endif; ?>">
                                        <?php if( $list['icon_items'] ): ?>
										 <?php foreach($list['icon_items'] as $icon ): ?>
                                        <li class="courses__icon-item">
                                            <picture>
                                                <source
                                                    srcset="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/courses/icon/<?php echo "{$icon['text']}" ; ?>.webp 1x, <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/courses/icon/<?php echo "{$icon['text']}" ; ?>@2x.webp 2x"
                                                    type="image/webp" />

                                                <source
                                                    srcset="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/courses/icon/<?php echo "{$icon['text']}" ; ?>.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/courses-all/courses/icon/<?php echo "{$icon['text']}" ; ?>@2x.png 2x"
                                                    type="image/png" />

                                                <img class="courses__icon-img"
                                                    src="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/courses/icon/<?php echo "{$icon['text']}" ; ?>.png"
                                                    alt="<?php the_field('courses_icon_alt'); ?>"
                                                    width="<?php if( $list['icon_width'] ): ?><?php echo "{$list['icon_width']}" ;?><?php else :?>50<?php endif; ?>"
                                                    height="50" />
                                            </picture>
                                        </li>
                                        <?php endforeach; ?> <?php else :?> 
										<?php foreach($list['items'] as $items ): ?>
                                        <li class="courses__text-item"><?php echo "{$items['text']}" ; ?></li>
                                         <?php endforeach; ?> <?php endif; ?>
                                    </ul>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <button class="courses__up-btn" type="button" data-show-less>
                        <svg class="courses__up-icon" width="32" height="32">
                            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/courses-all/sprite.svg#icon-arrow-up"></use>
                        </svg>
                    </button>
                </div>
            </li>
 <?php endforeach; ?>
           
        </ul>
	<?php endif; ?>	
    </div>
</section>