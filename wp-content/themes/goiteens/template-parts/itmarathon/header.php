<header class="header" id="home">
    <div class="header__main-wrap ">
        <div class="header__top header-js">
            <div class="container">
                <div class="header__wrapper">
                    <div class="header__nav-wrapper">
                        <a class="link" href="<?php echo home_url('/'); ?>" target="_blank" rel="nofollow noopener noreferrer" aria-label="<?php the_field('link_area_lab'); ?>" >
                            <img class="header__logo-img" src=" <?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/logo.svg" alt="<?php the_field('logo_alt'); ?>" width="143" height="37" />
                        </a>

                        <?php get_template_part( 'template-parts/itmarathon/components/navigation', get_post_type()  ); ?>

                        <button type="button" class="mobile-menu-btn" data-menu-btn aria-label="<?php the_field('btn_open_lab'); ?>">
                            <svg class="mobile-menu-svg" width="57" height="57">
                                <use href="<?php echo get_template_directory_uri(); ?>/assets/images/itmarathon/sprite.svg#icon-mobile-menu"></use>
                            </svg>
                        </button>

                    </div>

                    <?php $header = get_field('header', 'option'); ?>
                    <a class="header__tel link" href="tel:<?php echo "{$header['phone_href']}"; ?>"><?php echo "{$header['phone']}"; ?></a>

                </div>
            </div>
        </div>
        <div class="header-cont header-cont-js">
            <div class="container">
                <div class="hd__text">

                    <div class="hd__date">
                        <?php the_field('start_date'); ?>
                    </div>
                    <h1 class="hd__title">
                        <?php the_field('header_cont_title'); ?>
                    </h1>

                    <div class="hd__subtitle">
                        <?php the_field('header_cont_subtitle'); ?>
                    </div>

                    <?php $headerList = get_field('header_cont_items');
                    if( $headerList ): ?>
                        <ul class="hd__list">
                            <?php foreach( $headerList as $item ): ?>
                                <li><?php echo "{$item['text']}"; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="header-cont__box-btn">
                    <?php  $btnText= get_field('regist_btn');
                    $btnStyle="header-cont__btn main-btn--violet hd__btn";
                    $btnDataModal="data-modal-open"
                    ?>
                    <?php get_template_part( 'template-parts/itmarathon/components/btn', null, ['btnText' => $btnText, 'btnStyle' => $btnStyle, 'btnDataModal' => $btnDataModal ]  ); ?>

                </div>
            </div>
        </div>
    </div>

</header>
<?php get_template_part( 'template-parts/itmarathon/components/mobile-menu', get_post_type()  ); ?>
<?php get_template_part( 'template-parts/itmarathon/components/modal-video', get_post_type()  ); ?>
