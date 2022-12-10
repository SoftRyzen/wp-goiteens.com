<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block3_show');
    if( $hide ) return;
}

$title = get_field('block3_title');
$prices = get_field('block3_prices');
$exchange = get_option('exchange_privatbank');

?>

<?php if( $prices ) { ?>
    <section class="studding-payments">
        <div class="container-sales">

            <?php if( !empty($title) ) { ?>
                <h2 class="visually-hidden"><?= $title ?></h2>
            <?php } ?>

            <ul class="studding-payments_currency-tabs-list">
                <li class="studding-payments_currency-tabs-item">
                    <button data-tab="usd" class="studding-payments_currency-tabs-btn">
                        <?= _e( 'USD', 'goiteens' ) ?> $
                    </button>
                </li>
                <li class="studding-payments_currency-tabs-item">
                    <button data-tab="uah" class="studding-payments_currency-tabs-btn studding-payments_currency-tabs-btn--active">
                        <?= _e( 'ГРН', 'goiteens' ) ?> ₴
                    </button>
                </li>
                <li class="studding-payments_currency-tabs-item">
                    <button data-tab="euro" class="studding-payments_currency-tabs-btn">
                        <?= _e( 'EUR', 'goiteens' ) ?> €
                    </button>
                </li>
            </ul>

            <div class="studding-payments_currency-tabs-list-content">

                <div class="studding-payments_currency-tabs-list-content-item">

                    <ul class="studding-payments_per-month-list">

                        <?php foreach ( $prices as $price ) { ?>
                            <li class="studding-payments_per-month-item">
                                <h3 class="studding-payments_quantity-months">
                                    <?= $price['title'] ?>
                                </h3>
                                <div class="studding-payments_box">

                                    <?php if( !empty($price['sale_price']) ) { ?>

                                        <?php
                                        $oldprice = $price['regular_price'];
                                        $newprice = $price['sale_price'];
                                        $percent = round((($oldprice-$newprice)/$oldprice)*100);
                                        ?>
                                        <span class="studding-payments_discount">-<?= $percent ?>%</span>
                                    <?php } ?>

                                    <ul class="studding-payments_price-list active" data-prices="uah">

                                        <?php if( !empty($price['sale_price']) ) { ?>
                                            <li class="studding-payments_new-price">
                                                <span ><?= $price['sale_price'] ?></span>
                                                <span ><?= _e( 'грн.', 'goiteens' ) ?></span>
                                            </li>
                                            <li class="studding-payments_previous-price">
                                                <span><?= $price['regular_price'] ?></span>
                                                <span ><?= _e( 'грн.', 'goiteens' ) ?></span>
                                            </li>
                                        <?php } else { ?>
                                            <li class="studding-payments_new-price">
                                                <span ><?= $price['regular_price'] ?></span>
                                                <span ><?= _e( 'грн.', 'goiteens' ) ?></span>
                                            </li>
                                        <?php } ?>
                                    </ul>

                                    <?php if( $exchange ) { ?>

                                        <?php
                                        $key_usd = null;
                                        $key_usd = array_search('USD', array_column($exchange, 'ccy'));
                                        ?>
                                        <?php if( !is_null($key_usd) ) { $kurs = $exchange[$key_usd]['sale']; ?>
                                            <ul class="studding-payments_price-list" data-prices="usd">
                                                <?php if( !empty($price['sale_price']) ) { ?>
                                                    <li class="studding-payments_new-price">
                                                        <span ><?= ceil($price['sale_price'] / $kurs) ?></span>
                                                        <span ><?= _e( 'USD', 'goiteens' ) ?></span>
                                                    </li>
                                                    <li class="studding-payments_previous-price">
                                                        <span><?= ceil($price['regular_price'] / $kurs) ?></span>
                                                        <span ><?= _e( 'USD', 'goiteens' ) ?></span>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="studding-payments_new-price">
                                                        <span ><?= ceil($price['regular_price'] / $kurs) ?></span>
                                                        <span ><?= _e( 'USD', 'goiteens' ) ?></span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>

                                        <?php
                                        $key_euro = null;
                                        $key_euro = array_search('EUR', array_column($exchange, 'ccy'));
                                        ?>
                                        <?php if( !is_null($key_euro) ) { $kurs = $exchange[$key_euro]['sale']; ?>
                                            <ul class="studding-payments_price-list" data-prices="euro">

                                                <?php if( !empty($price['sale_price']) ) { ?>
                                                    <li class="studding-payments_new-price">
                                                        <span ><?= ceil($price['sale_price'] / $kurs) ?></span>
                                                        <span ><?= _e( 'EUR', 'goiteens' ) ?></span>
                                                    </li>
                                                    <li class="studding-payments_previous-price">
                                                        <span><?= ceil($price['regular_price'] / $kurs) ?></span>
                                                        <span ><?= _e( 'EUR', 'goiteens' ) ?></span>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="studding-payments_new-price">
                                                        <span ><?= ceil($price['regular_price'] / $kurs) ?></span>
                                                        <span ><?= _e( 'EUR', 'goiteens' ) ?></span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>

                                    <?php } ?>
                                   <div class="studding-payments_tabs-box">
                                    <a href="#pay-card" class="studding-payments_button-pay">
                                        <?= $price['button_text'] ?>
                                    </a>
                                    <ul class="studding-payments_tabs-list">
                                        <li class="studding-payments_tabs-item"><a href="#" class="studding-payments_tab-pay"></a></li>
                                        <li class="studding-payments_tabs-item"> <a href="#" class="studding-payments_tab-pay"></a></li>
                                    </ul>
                                    </div>
                                </div>

                            </li>
                        <?php } ?>

                    </ul>

                </div>

            </div>

        </div>
    </section>
<?php } ?>
