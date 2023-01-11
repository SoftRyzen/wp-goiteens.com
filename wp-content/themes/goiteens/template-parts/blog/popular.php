<?php
$popularPost = get_field('populars');
?>

<?php if( $popularPost ) { ?>
    <!-- Popular -->
    <section class="popular blogListPreload">
        <div class="container">
            <h2 class="popular-title"><?= get_field('populars_title') ?></h2>
           
           <ul class="popular-list">
           <li class="popular-item">
            <span class="popular-label">Поради СЕО</span>
           <img class="item_img"  loading="lazy" alt="smiling boy" src="<?= get_template_directory_uri() ?>/assets/images/blog/car-1-1x.jpg"
        srcset="<?= get_template_directory_uri() ?>/assets/images/blog/card-1-2x.jpg 2x"/>
            <div class="popular-box">
                <h3 >Які навички знадобляться дітям в 2025 році</h3>
                <p >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                <div><a href="">Читати далі ›</a> <svg width="13" height="13">

<use href="<?= get_template_directory_uri() ?>/assets/images/blog/sprite.svg#icon-small-clock"></use>

</svg>5хв</span></div></div>
</li>
<li class="popular-item">
<span class="popular-label">Поради СЕО</span>
<img class="item_img"  loading="lazy" alt="winner's cup" src="<?= get_template_directory_uri() ?>/assets/images/blog/card-2-1x.jpg "
        srcset="<?= get_template_directory_uri() ?>/assets/images/blog/card-2-2x.jpg 2x"/>
            <div class="popular-box">
                <h3>Які навички знадобляться дітям в 2025 році</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                <div><a href="">Читати далі ›</a> <svg width="13" height="13">

<use href="<?= get_template_directory_uri() ?>/assets/images/blog/sprite.svg#icon-small-clock"></use>

</svg>5хв</span></div></div>
           </li>
           <li class="popular-item">
           <span class="popular-label">Поради СЕО</span>
           <img class="item_img" loading="lazy" alt="boy" src="<?= get_template_directory_uri() ?>/assets/images/blog/card-3-1x.jpg "
        srcset="<?= get_template_directory_uri() ?>/assets/images/blog/card-3-2x.jpg  2x"/>
            <div class="popular-box">
                <h3>Які навички знадобляться дітям в 2025 році</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                <div><a href="">Читати далі ›</a> <svg width="13" height="13">

<use href="<?= get_template_directory_uri() ?>/assets/images/blog/sprite.svg#icon-small-clock"></use>

</svg>5хв</span></div>
           </li>
           </ul>
            <button class="popular-button blogListBtn" type="button"><?= _e( 'Дивитися більше', 'goiteens' ) ?></button>
        </div>

    </section>
    
<?php } ?>
