<section class="section">
  <div class="container">
    <div class="section-link">
      <h2 class="section-title"><?php the_field('referral_title'); ?></h2>
      <div class="section-link_description_wrapper">
        <?php $descriptionList = get_field('referral_description');
		if( $descriptionList ): ?>
        <?php foreach($descriptionList as $item ): ?>
        <p><?php echo "{$item['text']}"; ?></p>
        <?php endforeach; ?>
		  <?php endif; ?>
        <a class="main-btn courses__btn menu-link link" href="#all_courses"><?php the_field('referral_link_btn'); ?></a>
      </div>
    </div>
  </div>
</section>
