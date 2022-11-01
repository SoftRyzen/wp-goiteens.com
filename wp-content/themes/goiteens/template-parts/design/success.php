<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>
<section class="section signup">
    <div class="container ">
        <div class="signup__wrapper">
        <?php $creativeList = $euPage ? get_field('success_items_eu') : get_field('success_items');
		foreach($creativeList as $item ): ?>
			<p class="text-bold "><?php echo "{$item['text']}"; ?></p>
		<?php endforeach; ?>
        </div>
  		<?php get_template_part( 'template-parts/design/components/btn-wrapper' ); ?>
    </div>
</section>