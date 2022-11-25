<?php
namespace goiteens\model;

class database
{

	protected $wpdb;
	protected $tables = [];

	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;

		$this->tables = [
			'options' => $this->wpdb->prefix . 'options',
			'posts' => $this->wpdb->prefix . 'posts',
			'users' => $this->wpdb->prefix . 'users',
		];

	}
}

?>