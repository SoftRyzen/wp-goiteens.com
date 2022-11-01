<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section schedule">
    <div class="container">
        <h2 class="section__title schedule-title"><?php the_field('schedule_title'); ?></h2>
        <div class="schedule__content">
            <p class="text-label schedule__content-label"><?php the_field('title_descript'); ?></p>
			<?php $scheduleList = get_field('schedule_list');
				if( $scheduleList ): ?> 
            	<ul class="list grid schedule__calendar-list">
					<?php foreach( $scheduleList as $item ): ?>                
                	<li class="grid__item schedule__calendar-item">
						<div>
							<h3 class="section__subtitle schedule__calendar-title"><?php echo "{$item['title']}"; ?></h3>
							<p class="text__description schedule__calendar-text"><?php echo "{$item['text']}"; ?></p>
						</div>
                	</li>
                	<?php endforeach; ?>
    			</ul>
			<?php endif; ?>
            <p class="text-label schedule__content-label"><?php the_field('title_descript2'); ?></p>
		<?php $timeList = get_field('time_list');
			if( $timeList ): ?> 
            <ul class="list grid schedule__time-list">
				<?php foreach( $timeList as $item ): ?>
                <li class="grid__item schedule__time-item">
                    <div>
                        <h3 class="section__subtitle schedule__time-title"><?php echo "{$item['title']}"; ?></h3>
                        <p class="text__description schedule__time-text"><?php echo "{$item['text']}"; ?></p>
                    </div>
                </li>
               <?php endforeach; ?>
    		</ul>
		<?php endif; ?>
			<button type="button" class="main-btn schedule__btn btn-icon main-btn--violet" data-modal-open><?php $euPage ? the_field('button_eu') : the_field('button'); ?></button>
            <div class="schedule__img"></div>
        </div>
    </div>
</section>