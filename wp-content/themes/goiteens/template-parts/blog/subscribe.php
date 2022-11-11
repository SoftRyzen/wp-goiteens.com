<?php

?>
<!-- Subscribe Form -->
<section class="subscribe">
    <div class="container">
        <h2 class="subscribe-title">
            <?php
            echo sprintf( __( '<span class="subscribe-text__span">%s</span>%s<span class="subscribe-text__span">%s</span>', 'goiteens' ), 'Підпишися', ' на розсилку, аби не пропустити', ' актуальні новини' );
            ?>
        </h2>

        <div class="subscribe-form__wrapper">
            <form class="subscribe-form">
                <div class="subscribe-form__box">
                    <label class="subscribe-form__label">
                        <input class="input subscribe-form__input" type="text" placeholder="<?= _e( 'email', 'goiteens' ) ?>" name="email">
                    </label>
                    <button class="button subscribe-form__button" type="submit"><?= _e( 'Надіслати', 'goiteens' ) ?></button>
                </div>

                <label class="subscribe-form__label subscribe-form__label--padding">
                    <input class="subscribe-form__checkbox" type="checkbox">
                    <?php _e( 'Я приймаю умови конфіденційності', 'goiteens' ) ?>
                </label>

            </form>
        </div>
    </div>
</section>
<!-- End Subscribe Form -->
