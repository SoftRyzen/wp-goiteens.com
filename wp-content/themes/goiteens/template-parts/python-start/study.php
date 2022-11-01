<section class="section study">
  <div class="container">
    <h2 class="section-title"><?php the_field('study_title'); ?></h2>
	  
	<?php if(get_the_ID() == 6489 || get_the_ID() == 6850 ):?>
	  <?php 
		if(get_the_ID() == 6489){
			$imgSrc = "fe-start";
		}elseif(get_the_ID() == 6850){
			$imgSrc = "design-start";
		}
		;?>
	   <picture class="study-img-wrap">
      <img class="study-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $imgSrc ;?>/study/study.gif" alt="анімоване зображення навчального курсу GoIteens" width="800" height="363" />
    </picture>
	  <?php endif ;?>
	  
    <p class="description"><?php the_field('study_description'); ?></p>
	<?php $studyList = get_field('study_list');
	if( $studyList ): ?> 
    <ul class="list card-set">
     	<?php foreach( $studyList as $item ): ?>	
      <li class="item card-set-item">
        <h3 class="item-title text-accent"><?php echo "{$item['title']}"; ?></h3>
        <p><?php echo "{$item['description']}"; ?></p>
      </li>
      <?php endforeach; ?>
    </ul>
	  <?php endif; ?>
  </div>
</section>
<section class="section advantages">
  <div class="container">
	  <?php $studyInfo = get_field('study_info');
	if( $studyInfo ): ?> 
    <ul class="list card-set">
      <?php foreach( $studyInfo as $item ): ?>	
      <li class="card-set-item study-info-item">
        <h3 class="item-title text-accent"><?php echo "{$item['title']}"; ?></h3>
        <p><?php echo "{$item['description']}"; ?></p>
      </li>
     <?php endforeach; ?>
    </ul>
	   <?php endif; ?>
  </div>
</section>
