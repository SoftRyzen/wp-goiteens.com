<section class="section awards">
  <div class="container">
    <div class="side-left">
      <h2 class="section-title"><?php the_field('awards_title'); ?></h2>
      <p class="description"><?php the_field('awards_description'); ?></p>
      <p><?php the_field('awards_info'); ?></p>
    </div>
    <div class="side-right">
      <ul class="list card-set">
       <?php
		$awards_section = array(
			'numberposts'      => 150,
			'order'            => 'ASC',
			'post_type'        => 'awards',
			'category_name'	   => 'python-start',
			'suppress_filters' => false
		);
		$awards_list = get_posts( $awards_section );

		foreach ( $awards_list as $key=>$item ) {
			$result = '';
			setup_postdata( $item );
			?>
        <li class="item card-set-item">
          <h3 class="item-title text-accent"><?php echo $item->award_title; ?></h3>
          <p><?php echo $item->award_description; ?></p>
        </li>
         <?php } ?>
      </ul>
    </div>
  </div>
</section>
