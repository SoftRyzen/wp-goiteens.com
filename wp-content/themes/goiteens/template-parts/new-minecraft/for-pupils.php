<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block3_show');
    if( $hide ) return;
}

$title = get_field('block3_title');

?>
<section class="for-pupils">
    <div class="container">
        <h2 class="section-title">Програма курсу розроблена спеціально для учнів 1-2 класів</h2>
        <p class="text">Ідеально підійде дитині, яка…</p>
        <ul class="for-pupils_list">

            <li class="for-pupils_item">
                <img  alt="bit red heart" width="40" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-2x.png 2x"/>
                <h3>Захоплюється іграми, гаджетами</h3>
                <img  alt="bit red heart" width="26" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-2x.png 2x"/>
                <p>ми ніжно направимо ентузіазм в корисне русло</p>
            </li>
            <li class="for-pupils_item">
            <img  alt="bit red heart" width="40" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-2x.png 2x"/>
                <h3>Має інженерне мислення, будує з лего</h3>
                <img  alt="bit red heart" width="26" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-2x.png 2x"/>
                <p>навчимо втілювати найсміливіші ідеї в цифров ому світі</p>
            </li>
            <li class="for-pupils_item">
            <img  alt="bit red heart" width="40" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-2x.png 2x"/>
                <h3>Мислить творчо, має розвинену уяву</h3>
                <img  alt="bit red heart" width="26" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-2x.png 2x"/>
                <p>покажемо, як реалізувати творчий потенціал у створенні ігрових світів</p>
            </li>
            <li class="for-pupils_item">
            <img  alt="bit red heart" width="40" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-2x.png 2x"/>
                <h3>Має гарні математичні здібності</h3>
                <img  alt="bit red heart" width="26" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-2x.png 2x"/>
                <p>програма курсу допоможе їх розкрити і прокачати</p>
            </li>
            <li class="for-pupils_item">
            <img  alt="bit red heart" width="40" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/heart-img-2x.png 2x"/>
                <h3>Або навпаки, не дружить з математикою</h3>
                <img  alt="bit red heart" width="26" height="32" loading="lazy"
                 src="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-1x.png"
        srcset="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/arrow-img-2x.png 2x"/>
                <p>навчимо рахувати та розуміти математичні закони без сліз</p>
            </li>
        </ul>
        <div class="for-pupils_info-block">
        <svg>

<use href="<?= get_template_directory_uri() ?>/assets/images/new-minecraft/sprite1.svg#icon-idea"></use>

</svg>
            <p><span>7-8 років —</span> час, коли дитина формується, як особистість. Саме тому важливо вже зараз вкласти в неї фундаментальні знання та допомогти встановити позитивні асоціації з процесом навчання.</p>
        </div>
    </div>
</section>
