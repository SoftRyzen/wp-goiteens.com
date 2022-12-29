<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GoITeens
 */

?>
<?php

if (is_page_template('templates/tmpl-python-start-page.php')) {
    if (get_the_ID() == 6489 || get_the_ID() == 6850) {
        get_template_part('template-parts/python-start/modal-autopay');
    } elseif (8820 == get_the_ID()) {
        get_template_part('template-parts/python-start/modal-no-pay');
    } else {
        get_template_part('template-parts/python-start/modal');
    }


} elseif (is_page_template('templates/tmpl-itmarathon-page.php')) {

    $secondFormStep = get_field('second_step', 'option');
    $modalInfoText = get_field('modal_info_text', 'option');
    get_template_part('template-parts/itmarathon/modal', null, $args = array('secondFormStep' => $secondFormStep, 'modalInfoText' => $modalInfoText));

} elseif (is_page_template('templates/tmpl-minecraft-page.php')) {
    if (get_locale() == 'pl_PL' || get_locale() == 'en_US') {
        get_template_part('template-parts/minecraft/modal');
    } else if (get_the_ID() == 7520) {
        $userPhoneMessenger = get_field('user_phone_messenger', 'option');
        get_template_part('template-parts/modal', null, $args = array('userPhoneMessenger' => $userPhoneMessenger));
    } else {
        $secondFormStep = get_field('second_step', 'option');
        $modalInfoText = get_field('modal_info_text', 'option');
        $userPhoneMessenger = get_field('user_phone_messenger', 'option');
        get_template_part('template-parts/modal', null, $args = array('secondFormStep' => $secondFormStep, 'modalInfoText' => $modalInfoText, 'userPhoneMessenger' => $userPhoneMessenger));
    }

} elseif (is_page_template('templates/tmpl-design-page.php')) {
    $secondFormStep = get_field('second_step', 'option');
    $userPhoneMessengerDesign = get_field('user_phone_messenger', 'option');
    get_template_part('template-parts/modal', null, $args = array('userPhoneMessenger' => $userPhoneMessengerDesign, 'secondFormStep' => $secondFormStep));
} elseif (is_page_template('templates/tmpl-roblox-page.php')) {
    $secondFormStep = get_field('second_step', 'option');
    $userPhoneMessengerRoblox = get_field('user_phone_messenger', 'option');
    get_template_part('template-parts/modal', null, $args = array('userPhoneMessenger' => $userPhoneMessengerRoblox, 'secondFormStep' => $secondFormStep));


} elseif (is_page_template('templates/tmpl-python-page.php') || is_page_template('templates/tmpl-frontend-junior-page.php') || is_page_template('templates/tmpl-frontend-page.php') || is_page_template('templates/tmpl-programming4kids-page.php')) {
    $secondFormStep = get_field('second_step', 'option');

    get_template_part('template-parts/modal', null, $args = array('secondFormStep' => $secondFormStep));


} elseif (is_page_template('templates/tmpl-courses-all-page.php')) {
    get_template_part('template-parts/courses-all/components/modal');
} elseif (is_page_template('templates/tmpl-vacancies-page.php')) {
    get_template_part('template-parts/vacancies/modal');
} elseif (is_page_template('templates/tmpl-game-of-teens-page.php')) {
    get_template_part('template-parts/game-of-teens/modal');
} elseif (!is_page_template('templates/tmpl-python-start-thx-page.php') && !is_page_template('templates/tmpl-contract-page.php') && !is_page_template('templates/tmpl-blog-page.php') && !is_page_template('templates/tmpl-pl-vacancies-pm-page.php')) {
    get_template_part('template-parts/modal');

}; ?>
</div><!-- #page -->

<?php wp_footer();

/**
 * Test No Pay
 */
if ( 8820 == get_the_ID() || 4777 == get_the_ID()) {

    $folder = (8820 == get_the_ID()) ? 'pythonstartnopay' : 'pythonautopay';

?>
<script>
    (function ($) {
        "use strict";

        $(document).on('submit', '#register_form', function (e) {

            e.preventDefault()
            var $this = $(this)

            $.ajax({
                type: 'POST',
                url: '<?= get_stylesheet_directory_uri() . '/assets/crm/' . $folder . '/lead.php' ?>',
                data: $this.serialize(),
                dataType: 'json',
                success: function (response) {
                    console.dir(response)
                },
                beforeSend: function () {},
                complete: function () {
                    let page_thanks = '<?= get_the_permalink(8825) ?>';
                    location.href = page_thanks;
                },
                error: function (e) {}

            })

        })


    })(jQuery);
</script>
<?php
}


if (get_field('binotel_hash')) { ?>

    <script type="text/javascript">
        (function (d, w, s) {
            var widgetHash = '<?php echo get_field('binotel_hash'); ?>',
                gcw = d.createElement(s);
            gcw.type = 'text/javascript';
            gcw.async = true;
            gcw.src = '//widgets.binotel.com/getcall/widgets/' + widgetHash + '.js';
            var sn = d.getElementsByTagName(s)[0];
            sn.parentNode.insertBefore(gcw, sn);
        })(document, window, 'script');
    </script>

<?php } ?>

</body>
</html>
