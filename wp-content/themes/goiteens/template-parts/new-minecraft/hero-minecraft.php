<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block1_show');
    if( $hide ) return;
}

$title = get_field('block1_title');

?>
<section class="hero-nm">
    <div class="container">
        <div class="hero-nm_marked">
        <p class="hero-nm_marked-text">Освітня програма для дітей 7-8 років</p>
        </div>
        <p class="hero-nm_start--info"><span>Граємо, рахуємо та програмуємо </span>на онлайн-курсі <br>
«Цікава математика і програмування у всесвіті Майнкрафт»</p>
        <h1 class="hero-nm_page-title">
            <span class="hero-nm_page-title--uppercase">актуальні знаяння,</span>
            що допоможуть дитині
<span>стати №1 </span>в школі та дорослому житті
        </h1>
        <p class="hero-nm_try-free">Спробуйте перший урок програми<span>безкоштовно</span></p>
        <button class="btn_registration">зареєструватися</button>
    </div>
</section>
