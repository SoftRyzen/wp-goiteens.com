<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block8_show');
    if( $hide ) return;
}

$title = get_field('block8_title');

?>
<section class="ten-reasons">
    <div class="container">
        <h2 class="section-title"><span>10 ПРИЧИН</span> навчатися на курсі
«Цікава математика і програмування у всесвіті Майнкрафт»
від GoITeens</h2>
        <ul class="ten-reasons_list">
            <li class="ten-reasons_item">
                <h3>Відточена програма</h3>
                <p>Оновлюємо та доповнюємо курс відповідно до світових тенденцій, тому діти отримують актуальні знання</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Комфортне навчання</h3>
                <p>Заняття проходять онлайн — навчайтеся з будь-якої точки України та світу</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Багато практики</h3>
                <p>Мінімум нудних лекцій та максимум роботи в ігровому просторі</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Записи уроків доступні 24/7</h3>
                <p>Якщо дитина пропустила заняття або хоче повторити матеріал — все необхідне під рукою</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Цікаві ДЗ</h3>
                <p>Домашні завдання для закріплення знань, які діти виконують охоче та завзято</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Зворотний зв'язок</h3>
                <p>Викладачі та ментори школи перевіряють домашні завдання та допомагають дітям</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Найкращі викладачі</h3>
                <p>В школі працюють кваліфіковані та досвідчені спеціалісти, яких діти просто обожнюють</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Велике ком’юніті студентів</h3>
                <p>Діти знайомляться, спілкуються та заводять нових друзів в школі GoITeens</p>
            </li>
            <li class="ten-reasons_item">
                <h3>Турбота про батьків :)</h3>
                <p>Регулярна звітність про успішність та відвідування, а також батьківське ком’юніті, де можна обговорювати будь-які питання</p>
            </li>
            <li class="ten-reasons_item">
                <h3>IT-академія GoITeens має бездоганну репутацію</h3>
                <p></p>
            </li>
        </ul>

        <p class="ten-reasons_info">GoITeens — IT-академія, що надає повноцінну системну IT-освіту дітям від 8 до 16 років. Створена на базі міжнародної освітньої платформи GoIT Global, партнера проєкту IT Ukraine та IT Generation.</p>
        <ul class="awards_list">
            <li class="awards_item"><img  src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/ukr-aw-19-22.png" width="198" height="64" loading="lazy" alt="українська народна премія перше місце з 2018 по 2022 роки"></li>
            <li class="awards_item"><img  src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/ukr-it-aw.png" width="165" height="64" loading="lazy"  alt="Ukrainian IT Awards"></li>
            <li class="awards_item"><img  src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/best-it-edu.png" width="154" height="64" loading="lazy"  alt="Best IT education"></li>
        </ul>
        <div class="info-box">
            <h3>Навчання доступне та зручне</h3>
            <p>«Навчання в GoITeens є добре організованим, чітким, доступним для учнів. Зручним і зрозумілим для батьків. Дитина змогла освоїти запланований матеріал навіть дистанційно. Є хороший зворотний зв'язок, що не може не тішити»</p>
            <p class="name">Марта Билень-Костікова</p>
        </div>
    </div>
</section>
