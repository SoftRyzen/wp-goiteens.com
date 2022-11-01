<section class="section skills">
  <div class="container">
    <div class="skills__title-wrapper">
      <h2 class="section-title skills__title"><?php the_field('skills_title') ;?></h2>
      <p class="text-label"><?php the_field('skills_description') ;?></p>
    </div>
	<?php $skillsList= get_field('skills_list');
	  if($skillsList): ?>
    <ul class="list grid skills__list">
      <?php foreach($skillsList as $key=> $item): ?>
      <li class="grid__item skills__item">
        <div class="skills__icon-wrap">
          <svg class="skills__icon" width="<?php echo"{$item['item_svg_width']}" ;?>" height="<?php echo"{$item['item_svg_height']}" ;?>">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/images/design/sprite.svg#skills-<?php echo $key+1; ?>"></use>
          </svg>
        </div>
        <p><?php echo"{$item['item_text']}" ;?></p>
      </li>
      <?php endforeach ;?>
    </ul>
<?php endif ;?>
  </div>
</section>