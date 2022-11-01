
<nav class="navigation">
<?php $navigation = get_field('navigation_list');
if( $navigation ): ?>
    <ul class="list menu">
       <?php foreach( $navigation as $item ): ?>
        <li class="menu-item">
            <a href="#<?php echo "{$item['link']}"; ?>" class="link menu-link"><?php echo "{$item['text']}"; ?></a>
        </li>

       <?php endforeach; ?>
    </ul>
	<?php endif; ?>
</nav>