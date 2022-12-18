<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block6_show');
    if( $hide ) return;
}

$title = get_field('block6_title');

?>
<section class="lessons">
    <div class="container">
        <h2 class="section-title">Кожне заняття — це неймовірна пригода, маса нових знань та крутих емоцій</h2>
        <ul class="lessons_list">
            <li class="lessons_item">
            <svg width="70" height="70">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-bulb-2"></use>

</svg>
                <p>Онлайн формат</p>
            </li>
            <li class="lessons_item">
            <svg width="70" height="70">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-business-3"></use>

</svg>
                <p>60 хв тривалість заняття</p>
            </li>
            <li class="lessons_item">
            <svg width="70" height="70">

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-target-3"></use>

</svg>
                <p>2 рази / тиждень в будні після школи або вихідні</p>
            </li>
        </ul>
        <h3 class="lessons_subtitle">Заняття складається з 3-х частин:</h3>
        <ul class="lessons_details-list">
            <li class="lessons_details-item">
                <p>Цікаві фішки та можливості Майнкрафту</p>
            </li>
            <li class="lessons_details-item">
                <p>Челенджі на логіку та математичні завдання</p>
            </li>
            <li class="lessons_details-item">
                <p>Творче завдання для реалізації ідеї за допомогою вивчених інструментів</p>
            </li>
        </ul>
        <strong class="suggestion-block" >Реєструйтеся на пробне заняття, щоб перевірити якість курсу на практиці!</strong>
<button class="btn_registration">зареєструватися</button>
</div>
</section>
