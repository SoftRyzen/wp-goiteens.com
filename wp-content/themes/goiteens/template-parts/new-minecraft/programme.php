<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block10_show');
    if( $hide ) return;
}

$title = get_field('block10_title');

?>
<section class="programme">
    <div class="container">
        <h2 class="section-title">Програма навчання у всесвіті Майнкрафт — це перший крок, який відчиняє дитині двері до будь-якого IT-напрямку</h2>
        <ul class="programme_list">
            <li class="programme_item">
                        <h3>Minecraft Kids</h3>
                        <p>7-8 років</p>
                        <img class="programme_img" width="83" height="171" loading="lazy" alt="хлопчик персонаж майнкрафта" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/boy-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/boy-2x.png 2x"/>

            </li>
            <li class="programme_item">
                <ul class="programme_details-list">
                    <li class="programme_details-item">
                        <h3>Minecraft Kids</h3>
                        <p>9-12 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Front-End Junior</h3>
                        <p>10-11 років</p>
                    </li>
                </ul>
            </li>
            <li class="programme_item">
                <ul class="programme_details-list">
                    <li class="programme_details-item">
                        <h3>Front-End Junior</h3>
                        <p>10-11 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Roblox</h3>
                        <p>11-12 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Design Junior</h3>
                        <p>10-11 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Front-End</h3>
                        <p>11-16 років</p>
                    </li>
                </ul>
            </li>
            <li class="programme_item">
                <ul class="programme_details-list">
                    <li class="programme_details-item">
                        <h3>Front-End </h3>
                        <p>11-16 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>GameDev</h3>
                        <p>13-16 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Digital Design</h3>
                        <p>11-16 років</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Python</h3>
                        <p>13-16 років</p>
                    </li>
                </ul>
            </li>
            <li class="programme_item">
                <ul class="programme_details-list">
                    <li class="programme_details-item">
                        <h3>Розробник сайтів</h3>
                        <p>середня ЗП від €2 000</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Розробник ігор</h3>
                        <p>середня ЗП від €2 700</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Діджитал дизайнер</h3>
                        <p>середня ЗП від €2 700</p>
                    </li>
                    <li class="programme_details-item">
                        <h3>Фул-стек розробник</h3>
                        <p>середня ЗП від €3 000</p>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</section>
