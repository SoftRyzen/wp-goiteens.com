<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block12_show');
    if( $hide ) return;
}

$title = get_field('block12_title');

?>
<section class="questions">
    <div class="container">
        <h2 class="section-title">Залишилися питання?</h2>
        <ul class="questions_list">
            <li class="questions_item">
                <h3>Що необхідно для занять?</h3>
                <p>Для навчання необхідно мати ноутбук або ПК та стабільне підключення до інтернету.
Програми для роботи та доступи до них ви отримаєте від куратора до початку курсу.</p>
            </li>
            <li class="questions_item">
                <h3>Навіщо потрібен пробний урок?</h3>
                <p>Пробний урок необхідний, щоб виявити здібності дитини та з’ясувати, чи підходить їй курс. На вступному занятті дитина познайомиться з платформою Minecraft:Education та разом із викладачем-методистом створить свій перший проєкт. Це дозволить оцінити рівень підготовки дитини та встановити цілі на курс. Також на цьому занятті батьки можуть обговорити організаційні та фінансові питання.</p>
            </li>
            <li class="questions_item">
                <h3>Чи необхідна допомога батьків під час навчання?</h3>
                <p>Ні, присутність батьків на заняттях курсу не потрібна. Вам не обов’язково сидіти разом з дитиною над домашніми завданнями, адже будь-яке питання дитина може вирішити разом з ментором.
Але на першому пробному занятті вам варто бути!</p>
            </li>
            <li class="questions_item">
                <h3>У моєї дитини складний характер, чи зуміють викладачі знайти до неї підхід?</h3>
                <p>Наші викладачі — це не лише кваліфіковані фахівці, вони ще й розуміються на дитячій психології.
Ми обираємо найкращих людей в команду, щоб кожна дитина почувала себе комфортно в школі GoITeens.</p>
            </li>
        </ul>
        <strong class="suggestion-block"><span>Ще досі вагаєтесь?</span>
        <span>Погляньте, як проходить навчання на курсі</span>
        Подайте заявку на вступне заняття прямо зараз</strong>
        <button class="main-btn btn_registration" data-modal-open>зареєструватися</button>
    </div>
</section>
