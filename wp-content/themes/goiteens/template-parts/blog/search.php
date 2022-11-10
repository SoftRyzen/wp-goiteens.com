<?php

?>
<!-- Search -->
<section class="search">

    <!-- container -->
    <div class="container">

        <!-- form -->
        <form class="search-form" method="get" action="<?= home_url('blog') ?>">

            <!-- label -->
            <label class="search-form__label">
                <input
                        class="input search-form__input"
                        type="text"
                        name="search"
                        placeholder="<?= _e( 'Пошук', 'goiteens' ) ?>"
                        value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
                >
                <button
                        class="button"
                        type="submit"
                >
                    <?= _e( 'Знайти', 'goiteens' ) ?>
                </button>
            </label>
            <!-- end label -->

            <?php
            $categories = get_categories( 'child_of=62' );
            if( $categories )
            {

                $cat_id = 0;
                if( is_category() )
                {
                    $category = get_category( get_query_var( 'cat' ) );
                    $cat_id = $category->cat_ID;
                }

                ?>
                <!-- label -->
                <label class="search-form__label">

                    <select
                            class="input search-form__select blogFilterCategorySelect"
                            name=""
                    >

                        <option value="" disabled selected hidden><?= _e('Обрати категорію', 'goiteens') ?></option>

                        <?php foreach( $categories as $category ) { ?>
                            <option value="<?= get_term_link( $category ) ?>" <?= ($cat_id == $category->term_id) ? ' selected' : '' ?> >
                                <?= $category->name ?>
                            </option>
                        <?php } ?>

                    </select>

                    <button
                            class="button blogFilterCategoryBtn"
                            type="button"
                    >
                        <?= _e( 'Фільтрувати', 'goiteens' ) ?>
                    </button>

                </label>

                <!-- end label -->
            <?php } ?>

        </form>
        <!-- end form -->

        <?php
        $bestCategories = get_field('categories');
        if( $bestCategories )
        {
            ?>
            <!-- wrapper -->
            <div class="search-wrapper">

                <!-- title -->
                <p class="search-wrapper__text">
                    <?= _e( 'Важливі рубрики', 'goiteens' ) ?>
                </p>
                <!-- end title -->

                <!-- list -->
                <ul class="search-wrapper__list">

                    <?php foreach ( $bestCategories as $cat ) { ?>

                        <li>
                            <a class="search-wrapper__link" href="<?= get_term_link( $cat ) ?>">
                                <?= $cat->name ?>
                            </a>
                        </li>

                    <?php } ?>

                </ul>
                <!-- end list -->

            </div>
            <!-- end wrapper -->

        <?php } ?>

    </div>
    <!-- end container -->

</section>
<!-- End Search -->
