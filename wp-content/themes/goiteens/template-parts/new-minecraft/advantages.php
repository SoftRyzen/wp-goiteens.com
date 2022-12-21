<?php
defined( 'ABSPATH' ) || exit;

if ( !is_admin() )
{
    $hide = get_field('block2_show');
    if( $hide ) return;
}
$list = get_field('block2_list');

?>
<?php if( $list ) { ?>
<section class="advantages">
    <div class="container">
        <h2 class="visually-hidden"></h2>
        <ul class="advantages_list">
            <?php foreach ( $list as $item ) { ?>
            <li class="advantages_item">
                <h3><?= $item['title'] ?></h3>
                <p><?= $item['text'] ?></p>
            </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php } ?>
