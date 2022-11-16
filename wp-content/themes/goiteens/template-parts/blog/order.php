<?php
$fields = get_field('offers');
?>
<!-- Lesson -->
<section class="lesson">

    <!-- container -->
    <div class="container">

        <!-- title -->
        <h2 class="lesson-title">
            <?= $fields['title'] ?>
        </h2>
        <!-- end title -->

        <!-- form -->
        <?= do_shortcode('[contact-form-7 id="' . $fields['form'] . '" title="" html_class="lesson-form wpcf7Submit"]') ?>
        <!-- end form -->

    </div>
    <!-- end container -->

</section>
<!-- End Lesson -->
