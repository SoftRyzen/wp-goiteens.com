<?php
  $post = $wp_query->post;
 
  if ($post->post_type === 'vacancies') { //slug  категории

      include(TEMPLATEPATH.'/single-vacancies-page.php');
	  
  } else {
      include(TEMPLATEPATH.'/single-default.php');
  }
?>