
<section class="section why">
    <div class="container ">
<?php $whyList = get_field('why_list');?>
        <ul class="list why__list">
           	<?php foreach ($whyList as $item): ?>
            <li class="why__item">
                <h3 class="section-title why__item-title"><?php echo "{$item['item_title']}"; ?></h3>
              	<?php foreach ($item['item_list'] as $item): ?>
                <p class="why__item-text"><?php echo "{$item['item_text']}"; ?></p>
               <?php endforeach; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>