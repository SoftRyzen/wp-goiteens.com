<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block11_show');
    if( $hide ) return;
}

$title = get_field('block11_title');

?>
<section class="reviews minecraftSwiperReviews">
    <div class="container">
        <h2 class="section-title">Ось що кажуть батьки про навчання</h2>
        <div class="swiper">
        <div class="reviews_list swiper-wrapper">
            <div class="swiper-slide">
                <div class="reviews_item">
                    <img class="reviews_img" width="60" height="60" loading="lazy" alt="Galyna Vynnyk" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/galyna.png"/>
                    <h3>Galyna Vynnyk</h3>
                    <a href="#" class="social-link">Facebook</a>
                    <p>Завдяки заняттям в Go ITeens вдалось спрямувати захоплення іграми в телефоні в корисне русло. Дякую викладачам та менеджеру за чудово організовану роботу. Син з радістю чекає кожного заняття. Бачу його успіхи і радію. Успіхів вашій команді!</p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="reviews_item">
                    <img class="reviews_img" width="60" height="60" loading="lazy" alt="Евгения Николаенко" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/evgehiia.png"/>
                    <h3>Евгения Николаенко</h3>
                    <a href="#" class="social-link">Facebook</a>
                    <p>Сьогодні моя дочка залишилась у захваті від пробного заняття. Вчитель зрозуміло і доступно пояснював їЇ зацікавили завдання, тому будемо вчитись далі з вами)))</p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="reviews_item">
                    <img class="reviews_img" width="60" height="60" loading="lazy" alt="Дмитро Кожушко" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/dima.png"/>
                    <h3>Дмитро Кожушко</h3>
                    <a href="#" class="social-link">Facebook</a>
                    <p>Є багато різних курсів, кружків, шкіл по вивченню чогось для дітей. Але що відрізняє Go-ITeens від інших - це поєднання сучасної освіти (актуальні знання) та майже цілодобова підтримка з боку співробітників. Викладачі змістовно дають матеріал у цікавій формі. Дякуємо за вашу роботу. Чудовий колектив! Суцільний позитив! 🙂</p>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="reviews_item">
                    <img class="reviews_img" width="60" height="60" loading="lazy" alt="Марта Билень-Костікова<" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/marta.png"/>
                    <h3>Марта Билень-Костікова</h3>
                    <a href="#" class="social-link">Facebook</a>
                    <p>Навчання у Go ITeens є добре організованим, чітким, доступним для учнів. Зручним і зрозумілим для батьків. Дитина змогла освоїти запланований матеріал навіть дистанційно. Є хороший зворотній зв'язок, що не може не тішити.</p>
                </div>
            </div>
        </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
