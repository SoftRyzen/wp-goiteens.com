		 <div class = "search-form-wrapper">
		<form class="modal-form search-form" action="<?php bloginfo( 'url' ); ?>" method="get">
			<input class="modal-input" type="text" name="s" placeholder="Пошук" value="<?php if(!empty($_GET['s'])){echo $_GET['s'];}?>"/>
			<input type="submit" class="main-btn search-btn" value="Знайти"/>
		</form>
			
		<?php $categories = get_categories( 'child_of=62' );?>
		<form  action="" method="post" class="modal-form search-form " >
	       <select name="event-dropdown" class="modal-input" onchange="document.location.href = this.options[ this.selectedIndex ].value";  >
				<option value=""><?php echo esc_attr( 'Оберіть категорію' ); ?></option>
			   <option value="<?php echo get_permalink(5408); ?>"><?php echo esc_attr( 'Всі категорії' ); ?></option>
				<?php foreach( $categories as $category ){

					$option = '<option value="' . get_term_link( $category ) . '">';
					$option .= $category->name;
					$option .= ' (' . $category->count . ')';
					$option .= '</option>';

					echo $option;
				}
				?>
			</select>
				<input type="submit" class="main-btn search-btn" value="Фільтрувати">
			</form>	
	 </div>