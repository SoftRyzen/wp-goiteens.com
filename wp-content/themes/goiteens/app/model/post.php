<?php
namespace goiteens\model;

/**
 * Post model
 */
class post extends database
{

	/**
	 * Get posts
	 */
	function get($args = [])
	{

		$default_args = [
			//'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page')
		];

		$query_args = array_merge($default_args, $args);

		$query = new \WP_Query($query_args);

		return $query;

	}

}

?>