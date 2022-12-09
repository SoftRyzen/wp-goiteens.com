<section class="home__dignity section">
	<div class="container">
		<h2 class="home__dignity-title title">
			<?php the_field('dignity_title'); ?>
		</h2>
		<?php $dignityList = get_field('dignity_list');
        if ($dignityList): ?>

		<ul class="home__dignity-list list grid">
			<?php foreach ($dignityList as $item): ?>
			<li class="home__dignity-item grid__item">
				<?php if (get_locale() !== 'pl_PL'): ?>
				<picture>
					<source
						srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg.webp    1x,
					              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg@2x.webp 2x"
						media="(min-width: 768px)" type="image/webp" />
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg.jpg    1x,
					              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_lg@2x.jpg 2x
					            " media="(min-width: 768px)" type="image/jpeg" />
					<source srcset="
					              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm.webp    1x,
					              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm@2x.webp 2x
					            " media="(max-width: 767px)" type="image/webp" />
					<source
						srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm@2x.jpg 2x"
						media="(max-width: 767px)" type="image/jpeg" />
					<img class="home__dignity-img"
						src="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/dignity-<?php echo $item['item_id']; ?>_sm.jpg"
						alt="<?php echo "{$item['item_img_alt']}"; ?>" width="334" height="195" loading="lazy" />
				</picture>
				<?php else: ?>
				<picture>
					<source
						srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg.webp    1x,
						              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg@2x.webp 2x"
						media="(min-width: 768px)" type="image/webp" />
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg.jpg    1x,
						              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_lg@2x.jpg 2x
						            " media="(min-width: 768px)" type="image/jpeg" />
					<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm.webp    1x,
						              <?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm@2x.webp 2x
						            " media="(max-width: 767px)" type="image/webp" />
					<source
						srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm@2x.jpg 2x"
						media="(max-width: 767px)" type="image/jpeg" />
					<img class="home__dignity-img"
						src="<?php echo get_template_directory_uri(); ?>/assets/images/main/dignity/pl/dignity-<?php echo $item['item_id']; ?>_sm.jpg"
						alt="<?php echo "{$item['item_img_alt']}"; ?>" width="334" height="195" loading="lazy" />
				</picture>
				<?php endif; ?>
				<h3 class="home_dignity-text text-bold">
					<?php echo "{$item['item_title']}"; ?>
				</h3>
				<p>
					<?php echo "{$item['item_text']}"; ?>
				</p>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</div>
</section>