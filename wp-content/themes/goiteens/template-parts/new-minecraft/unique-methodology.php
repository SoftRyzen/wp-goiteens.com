<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block9_show');
    if( $hide ) return;
}

$title = get_field('block9_title');

?>
<section class="methodology">
    <div class="container">
        <h2 class="section-title">IT-академія GoITeens розробила власну унікальну методологію навчання</h2>
        <ul class="methodology_list">
            <li class="methodology_item">
            <div class="percent-wrap">
                <h3 class="percent-label">10%</h3>
                </div>
                <ul class="methodology_details-list">
                    <li class="methodology_details-item">
                        Теоретична база зібрана та структурована
                    </li>
                    <li class="methodology_details-item">
                        Інформація доступною мовою
                    </li>
                    <li class="methodology_details-item">
                        Конспекти та відеозаписи до кожної теми
                    </li>
                </ul>
            </li>
            <li class="methodology_item">
            <div class="percent-wrap">
                <h3 class="percent-label">70%</h3>
                </div>
                <ul class="methodology_details-list">
                    <li class="methodology_details-item">
                        Практичні домашні завдання
                    </li>
                    <li class="methodology_details-item">
                        2 командних проєкти
                    </li>
                    <li class="methodology_details-item">
                        4+ особистих проєкти
                    </li>
                </ul>
            </li>
            <li class="methodology_item">
                <div class="percent-wrap">
                <h3 class="percent-label">20%</h3>
                </div>
                <ul class="methodology_details-list">
                    <li class="methodology_details-item">
                        Перевірка домашніх завдань
                    </li>
                    <li class="methodology_details-item">
                        Рекомендації від викладачів
                    </li>
                    <li class="methodology_details-item">
                        Допомога ментора у вирішенні будь-яких питань з навчання
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</section>
