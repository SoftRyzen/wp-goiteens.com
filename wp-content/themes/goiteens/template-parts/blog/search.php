<?php

?>
<!-- Search -->
<section class="find">

    <!-- container -->
    <div class="container">

        <!-- form -->
        <form class="find-form" method="get" action="<?= home_url('blog') ?>">

            <!-- label -->
            <label class="find-form__label">
                <input
                        class="find-form__input"
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
                <label class="find-form__label">

                    <select
                            class="find-form__select blogFilterCategorySelect"
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
            <div class="find-wrapper">

                <!-- title -->
                <button class="find-wrapper__text">
                    <?= get_field('categories_title') ?>
                </button>
                <!-- end title -->

                <!-- list -->
                <ul class="find-wrapper__list">

                    <?php foreach ( $bestCategories as $cat ) { ?>

                        <li>
                            <a class="find-wrapper__link" href="<?= get_term_link( $cat ) ?>">
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
