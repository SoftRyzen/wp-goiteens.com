<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block5_show');
    if( $hide ) return;
}

$title = get_field('block5_title');

?>
<section class="minecraft-edu">
    <div class="container">
        <div class="minecraft-edu_info-wrapper">
        <picture class="img-wrap">
        <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/minecraft-1x-desk.png 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/minecraft-2x-desk.png 2x" width="568" height="349"/>
        <source media="(min-width: 768px)" type="image/png" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/minecraft-1x-tab.png 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/minecraft-2x-tab.png 2x" width="316" height="198"/>
        <img class="item_img" width="240" height="151" loading="lazy" alt="minecraft logo" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/minecraft-1x-mob.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/minecraft-2x-mob.png 2x"/>
        </picture>
            <div class="box-content"><h3>Що таке Minecraft:Education?</h3>
            <p>Minecraft:Education — це офіційний освітній продукт від Microsoft, створений на базі всесвітньо відомої гри Minecraft. Її використовують в офіційних освітніх програмах 115 країн світу.</p>
            <p>Minecraft — цифровий аналог лего. Це унікальне середовище, в якому діти будують будь-які об’єкти із природних матеріалів (земля, дерево, каміння, тощо), а також створюють синтетичні елементи за допомогою крафту. Абсолютно все у грі будується із кубиків 1х1, тому вивчати точні науки в ній легко та цікаво.</p>
        </div></div>
        <h2 class="section-title">Дитина прокачає математичне мислення
та познайомиться з кодом просто у грі!</h2>
        <p class="text">Ми побудували навчальну програму курсу навколо теми <span>«Таємниці світу».</span>
Впродовж першого року навчання малеча досліджує таємниці світу, знайомиться з історією Європи та технологіями від давніх часів до сьогодення.</p>
        <div class="minecraft-edu_box">
            <div class="box-content"><h3 class="box-content_subtitle">Що будуємо?</h3>
            <p class="box-content_text">Виконуючи математичні розрахунки, діти зводять грандіозні об’єкти:</p>
            <ul class="minecraft-edu_list">
                <li class="minecraft-edu_item">Римський Амфітеатр</li>
                <li class="minecraft-edu_item">Голландську ферму</li>
                <li class="minecraft-edu_item">Венеціанські канали</li>
                <li class="minecraft-edu_item">Австрійську залізницю</li>
                <li class="minecraft-edu_item">Британське підземне метро та багато інших видатних споруд</li>
            </ul>
        </div>

        <picture class="img-wrap">
        <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-desk-1x.png 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-desk-2x.png 2x" width="589" height="392"/>
        <source media="(min-width: 768px)" type="image/png" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-tab-1x.png 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-tab-2x.png 2x" width="336" height="256"/>
        <img class="item_img" width="272" height="208" loading="lazy" alt="coliseum in minecraft" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-mob-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/coliseum-mob-2x.png 2x"/>
        </picture>
    </div>
        <div class="minecraft-edu_box">
        <picture class="img-wrap">
        <source media="(min-width: 1280px)" type="image/png" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/team-desk-1x.png 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/team-desk-2x.png 2x" width="520" height="427"/>
        <source media="(min-width: 768px)" type="image/png" srcset="
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/team-tab-1x.png 1x,
        <?= get_template_directory_uri() ?>/assets/images/new-minecraft/team-tab-2x.png 2x" width="284" height="224"/>
        <img class="item_img" width="272" height="224" loading="lazy" alt="пара персонажів" src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/team-mob-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/team-mob-2x.png 2x"/>
        </picture>
           <div class="box-content"> <h3 class="box-content_subtitle">Що програмуємо?</h3>
            <p class="box-content_text">За допомогою простого візуального програмування діти навчаються:</p>
            <ul class="minecraft-edu_list">
                <li class="minecraft-edu_item">створювати геометричні фігури та мобів</li>
                <li class="minecraft-edu_item">телепортувати персонажа чи об’єкт</li>
                <li class="minecraft-edu_item">виконувати прості математичні операції</li>
                <li class="minecraft-edu_item">керувати агентом (проходження через ландшафт / лабіринт тощо)</li>
                <li class="minecraft-edu_item">зациклювати дії</li>
                <li class="minecraft-edu_item">виконувати квестові умови та багато іншого</li>
            </ul>
            </div>
        </div>
    </div>
</section>
