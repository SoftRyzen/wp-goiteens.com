<section class="section course" id="course">
    <div class="container">
        <h2 class="section__title course__title"><?php the_field('course_title'); ?></h2>
		<?php $courseList = get_field('course_list');
			if( $courseList ): ?> 
			<ul class="list grid course__list">
				<?php foreach( $courseList as $items ): ?>
				<li class="grid__item">
					<?php foreach( $items['items'] as $item ): ?>
					<p><?php echo "{$item['text']}"; ?></p>
					<?php endforeach; ?>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>        
    </div>
</section>