<?php global $pl; ?>

<section class="home__hero">
	<div class="home__hero-wrapper">
		<picture class="home__hero-image-wrapper">
			<source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	             echo 'pl/';
             endif ?>boy_lg.webp    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	             echo 'pl/';
             endif ?>boy_lg@2x.webp 2x
        " media="(min-width: 1280px)" type="image/webp" />
			<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	               echo 'pl/';
               endif ?>boy_lg.png 1x, <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	                  echo 'pl/';
                  endif ?>boy_lg@2x.png 2x" media="(min-width: 1280px)" type="image/png" />

			<source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	             echo 'pl/';
             endif ?>boy_md.webp    1x,
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	             echo 'pl/';
             endif ?>boy_md@2x.webp 2x
        " media="(min-width: 768px)" type="image/webp" />
			<source srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	               echo 'pl/';
               endif ?>boy_md.png" media="(min-width: 768px)" type="image/png" />

			<source srcset="
          <?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	             echo 'pl/';
             endif ?>boy_sm.webp" media="(max-width: 767px)" type="image/webp" />

			<img class="home__hero-image" src="<?php echo get_template_directory_uri(); ?>/assets/images/main/hero/<?php if ($pl):
	               echo 'pl/';
               endif ?>boy_sm.png" alt="<?php the_field('hero_img_alt'); ?>" width="320" height="565" />
		</picture>
		<div class="container home__hero-title-wrapper">
			<div class="home__hero-text-wrapper">
				<?php
                $heroLabel = get_field('text_label');
                if ($heroLabel): ?>
				<p class="text-label home__hero-label">
					<?php the_field('text_label'); ?>
				</p>
				<?php endif; ?>
				<h1 class="home__hero-title">
					<?php the_field('hero_title'); ?>
				</h1>
				<p class="home__hero-text">
					<?php the_field('description'); ?>
				</p>
				<?php
                $heroList = get_field('hero_list');
                if ($heroList): ?>
				<ul class="list home__hero-list">
					<?php foreach ($heroList as $item): ?>
					<li class="home__hero-list-item">
						<?php echo "{$item['hero_list_text']}"; ?>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<button type="button" class="main-btn" data-modal-open>
				<?php the_field('page_button'); ?>
			</button>
		</div>
	</div>

	<?php get_template_part('template-parts/branches', get_post_type()); ?>

</section>