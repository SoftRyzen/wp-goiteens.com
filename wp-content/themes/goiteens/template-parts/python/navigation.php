<nav class="navigation">
	<?php $navigation = get_field('navigation');
	if( $navigation ): ?>
	<ul class="list menu">
		<?php foreach( $navigation as $item ): ?>
		<li class="menu-item">
			<a href="#<?php echo "{$item['navigation_link']}"; ?>" class="link menu-link"><?php echo "{$item['navigation_text']}"; ?></a>
		</li>
		<?php endforeach; ?>
    </ul>
	<?php endif; ?>
</nav>