<nav class="navigation">

    <?php $navigationList = get_field('navigation');
        if( $navigationList ): ?>
    <ul class="list menu">

        <?php foreach( $navigationList as $item ): ?>
        <li class="menu-item">
            <a href="#<?php echo "{$item['link']}"; ?>" class="link menu-link"
                data-menu-link><?php echo "{$item['text']}"; ?></a>
        </li>
        <?php endforeach; ?>

    </ul>
    <?php endif; ?>
</nav>