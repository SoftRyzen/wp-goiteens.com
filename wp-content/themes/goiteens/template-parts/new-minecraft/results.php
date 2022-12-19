<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block7_show');
    if( $hide ) return;
}

$title = get_field('block7_title');

?>
<section class="results">
    <div class="container">
        <h2 class="section-title">Реальні результати ви побачите вже в перші місяці роботи на курсі</h2>
        <ul class="results_list">
            <li class="results_item">

                <svg class="results_icon">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-heart"></use>

</svg>
<div>
                <h4>Любов до навчання</h4>
                <p>Завдяки ігровому формату, у дитини закріплюється асоціація «навчання — це цікаво і весело.</p>
                </div>
            </li>
            <li class="results_item">
            <svg class="results_icon">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-brain"></use>

</svg>
            <div>
                <h4>Міцна математична база</h4>
                <p>Фундаментальні математичні знання значно полегшують подальше засвоєння точних наук.</p></div>
            </li>
            <li class="results_item">
            <svg class="results_icon">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-gear"></use>

</svg >
            <div>
                <h4>Початкові навички програмування</h4>
                <p>Дитина розуміє основні поняття програмування та має підґрунтя для подальшого вивчення коду.</p></div>
            </li>
            <li class="results_item">
            <svg class="results_icon">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-bulbs"></use>

</svg>
            <div>
                <h4>Комунікативні навички</h4>
                <p>Дитина вміє знаходити спільну мову, презентувати себе, працювати в команді та відстоювати власну точку зору.</p></div>
            </li>
        </ul>
        <h3 class="subtitle-blog">Ми побудували програму так, щоб заняття сприяли всесторонньому розвитку дитини, тому під час роботи вона також прокачає:</h3>
        <ul class="results_development-list">
            <li class="results_development-item">
                <p>Логічне мислення</p>
            </li>
            <li class="results_development-item">
                <p>Просторова уява</p>
            </li>
            <li class="results_development-item">
                <p>Креативність</p>
            </li>
            <li class="results_development-item">
                <p>Мови: українську та англійську</p>
            </li>
        </ul>
        <div class="info-box">
            <h4>Існує багато курсів, але програма від GoITeens — це ТОП!</h4>
            <p>«Є багато різних курсів, гуртків, шкіл по вивченню чогось для дітей. Але що відрізняє GoITeens від інших — це поєднання сучасної освіти (актуальні знання) та майже цілодобова підтримка з боку співробітників. Викладачі змістовно дають матеріал у цікавій формі. Дякуємо за вашу роботу. Чудовий колектив! Суцільний позитив!»</p>
            <p class="name">Дмитро Кожушенко</p>
        </div>
        <strong class="suggestion-block">Перевірте, чи підходить програма вашій дитині на вступному занятті</strong>
        <p class="text">Це безкоштовно та швидко — всього 45 хвилин</p>
        <button class="btn_registration">зареєструватися</button>
    </div>
</section>
