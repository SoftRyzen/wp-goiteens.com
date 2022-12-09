<?php global $pl; ?>

<section class="home__achievments section">
	<div class="home__achievments-cont">
		<div class="container">
			<div class="home__achievments-wrapper">
				<picture>
					<source srcset="
              <?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if ($pl):
	                 echo 'pl/'; endif ?>vp_lg.webp    1x,
              <?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if ($pl):
	                 echo 'pl/'; endif ?>vp_lg@2x.webp 2x
            " media="(min-width: 1280px)" type="image/webp" />
					<source
						srcset="<?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if ($pl):
	                           echo 'pl/'; endif ?>vp_lg@2x.jpg 2x"
						media="(min-width: 1280px)" type="image/jpeg" />
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/main/achievments/<?php if ($pl):
	                       echo 'pl/'; endif ?>vp_lg.jpg"
						class="home__achievments-img" alt="<?php the_field('achievments_img_alt'); ?>" <?php echo ($pl) ? 
                          	'width="325" height="427"' : 'width="470" height="580"' ?>
					loading="lazy" />
				</picture>
				<div class="home__achievments-side">
					<h2 class="home__achievments-title">
						<?php the_field('achievments_title'); ?>
					</h2>
					<div class="home__achievments-content">
						<?php the_field('achievments_description'); ?>
						<p class="home__achievments-text">
							<?php the_field('achievments_author'); ?>
							<span>
								<?php the_field('achievments_position'); ?>
							</span>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>