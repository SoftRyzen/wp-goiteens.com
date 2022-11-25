<?php

?>
<!-- Search -->
<section class="search">

    <div class="container">

        <form class="search-form">
            <label class="search-form__label">
                <input class="input search-form__input" type="text" name="search" placeholder="<?= _e( 'Пошук', 'goiteens' ) ?>">
                <button class="button" type="submit"><?= _e( 'Знайти', 'goiteens' ) ?></button>
            </label>

            <?php
            $categories = get_categories( 'child_of=62' );
            if( $categories ) {
                ?>
                <label class="search-form__label">
                    <select class="input search-form__select" name="category">

                        <option value="" disabled selected hidden><?= _e('Обрати категорію', 'goiteens') ?></option>

                        <?php foreach( $categories as $category ) { ?>
                            <option value="<?= get_term_link( $category ) ?>"><?= $category->name ?></option>
                        <?php } ?>

                    </select>

                    <button class="button" type="submit"><?= _e( 'Фільтрувати', 'goiteens' ) ?></button>

                </label>
            <?php } ?>
        </form>

        <?php
        $bestCategories = get_field('categories');
        if( $bestCategories ) {
            ?>
            <div class="search-wrapper">
                <p class="search-wrapper__text"><?= _e( 'Важливі рубрики', 'goiteens' ) ?></p>
                <ul class="search-wrapper__list">
                    <?php foreach ( $bestCategories as $cat ) { ?>
                        <li>
                            <a class="search-wrapper__link" href="<?= get_term_link( $cat ) ?>"><?= $cat->name ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

    </div>
</section>
<!-- End Search -->
