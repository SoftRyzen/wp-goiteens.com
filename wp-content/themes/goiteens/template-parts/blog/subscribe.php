<?php
$fields = get_field('subscribe');
?>
<!-- Subscribe Form -->
<section class="subscribe">

    <!-- container -->
    <div class="container">

        <!-- title -->
        <h2 class="subscribe-title">
            <?= $fields['title'] ?>
        </h2>
        <!-- end title -->

        <!-- wrapper -->
        <div class="subscribe-form__wrapper">

            <?= do_shortcode('[contact-form-7 id="' . $fields['form'] . '" title="" html_class="subscribe-form wpcf7Submit"]') ?>

        </div>
        <!-- end wrapper -->

    </div>
    <!-- end container -->

</section>
<!-- End Subscribe Form -->
