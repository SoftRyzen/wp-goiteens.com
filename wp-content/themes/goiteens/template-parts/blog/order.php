<?php

?>
<!-- Lesson -->
<section class="lesson">
    <div class="container">
        <h2 class="lesson-title">
            <?php
            echo sprintf( __( '%s<span class="lesson-title__span">%s</span>%s', 'goiteens' ), 'Пройти', ' безплатно', ' пробне заняття' );
            ?>
        </h2>

        <form class="lesson-form">
            <label class="lesson-form__label">
                <input class="input lesson-form__input" type="text" placeholder="<?= _e( 'Ім\'я', 'goiteens' ) ?>">
            </label>

            <label class="lesson-form__label">
                <input class="input lesson-form__input" type="text" placeholder="<?= _e( 'Email', 'goiteens' ) ?>">
            </label>

            <button class="button lesson-form__button" type="submit"><?= _e( 'Надіслати', 'goiteens' ) ?></button>
        </form>

    </div>
</section>
<!-- End Lesson -->
