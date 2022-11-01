<?php $euPage=strpos($_SERVER['REQUEST_URI'], '-eu');?>    
<div class="btn-wrapper">
			<button type="button" class="main-btn btn-wrapper__btn btn-icon " data-modal-open >
			  <?php  $euPage ? the_field('btn_main_text_eu') : the_field('btn_main_text'); ?>
			</button>
    		<p class="btn-wrapper__notation"> <?php $euPage ? the_field('btn_design_notation_eu') : the_field('btn_design_notation'); ?></p>
	</div>