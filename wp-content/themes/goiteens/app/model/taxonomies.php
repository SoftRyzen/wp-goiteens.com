<?php
namespace goiteens\model;

/**
 * Taxonomies model
 */
class taxonomies extends database
{


	/**
	 * Register custom post types
	 */
	function register_post_types()
	{

		register_post_type(
			'student_projects',
			[
				'label' => null,
				'labels' => [
					'name' => 'Проекти учнів',
					'singular_name' => 'Проект',
					'add_new' => 'Додати проект',
					'add_new_item' => 'Додати новий проект',
					'edit_item' => 'Редактувати проект',
					'new_item' => 'Новий проект',
					'view_item' => 'Дивитись проект',
					'search_items' => 'Шукати проект',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-embed-photo',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);
		register_post_type(
			'testemonials',
			[
				'label' => null,
				'labels' => [
					'name' => 'Відгуки дітей',
					'singular_name' => 'Відгук',
					'add_new' => 'Додати відгук',
					'add_new_item' => 'Додати відгук',
					'edit_item' => 'Редактувати відгук',
					'new_item' => 'Новий відгук',
					'view_item' => 'Дивитись відгук',
					'search_items' => 'Шукати відгук',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-admin-comments',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'parent_review',
			[
				'label' => null,
				'labels' => [
					'name' => 'Відгуки батьків',
					'singular_name' => 'Відгук',
					'add_new' => 'Додати відгук',
					'add_new_item' => 'Додати новий відгук',
					'edit_item' => 'Редактувати відгук',
					'new_item' => 'Новий відгук',
					'view_item' => 'Дивитись відгук',
					'search_items' => 'Шукати відгук',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-money',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'courses',
			[
				'label' => null,
				'labels' => [
					'name' => 'Наші курси',
					'singular_name' => 'Курс',
					'add_new' => 'Додати курс',
					'add_new_item' => 'Додати новий курс',
					'edit_item' => 'Редактувати курс',
					'new_item' => 'Новий курс',
					'view_item' => 'Дивитись курс',
					'search_items' => 'Шукати курс',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-welcome-learn-more',
				'hierarchical' => false,
				'supports' => ['title', 'custom-fields', 'page-attributes'],
				'taxonomies' => [],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'teachers',
			[
				'label' => null,
				'labels' => [
					'name' => 'Викладачі',
					'singular_name' => 'Викладач',
					'add_new' => 'Додати викладача',
					'add_new_item' => 'Додати нового викладача',
					'edit_item' => 'Редактувати викладача',
					'new_item' => 'Новий викладач',
					'view_item' => 'Дивитись викладача',
					'search_items' => 'Шукати викладача',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-groups',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'speakers',
			[
				'label' => null,
				'labels' => [
					'name' => 'Спікери',
					'singular_name' => 'Спукер',
					'add_new' => 'Додати спікера',
					'add_new_item' => 'Додати нового спікера',
					'edit_item' => 'Редактувати спікера',
					'new_item' => 'Новий спікер',
					'view_item' => 'Дивитись спікера',
					'search_items' => 'Шукати спікера',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-megaphone',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => [],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'game_speakers',
			[
				'label' => null,
				'labels' => [
					'name' => 'GAME Спікери',
					'singular_name' => 'GAME Спiкер',
					'add_new' => 'Додати спікера',
					'add_new_item' => 'Додати нового спікера',
					'edit_item' => 'Редактувати спікера',
					'new_item' => 'Новий спікер',
					'view_item' => 'Дивитись спікера',
					'search_items' => 'Шукати спікера',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-megaphone',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'partners',
			[
				'label' => null,
				'labels' => [
					'name' => 'Партнери',
					'singular_name' => 'Партнер',
					'add_new' => 'Додати партнера',
					'add_new_item' => 'Додати нового партнера',
					'edit_item' => 'Редактувати партнера',
					'new_item' => 'Новий партнер',
					'view_item' => 'Дивитись партнера',
					'search_items' => 'Шукати партнера',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-megaphone',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'awards',
			[
				'label' => null,
				'labels' => [
					'name' => 'Нагороди',
					'singular_name' => 'Нагорода',
					'add_new' => 'Додати нагороду',
					'add_new_item' => 'Додати нового нагороду',
					'edit_item' => 'Редактувати нагороду',
					'new_item' => 'Нова нагорода',
					'view_item' => 'Дивитись нагороду',
					'search_items' => 'Шукати нагороду',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-star-filled',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'vacancies',
			[
				'label' => null,
				'labels' => [
					'name' => 'Вакансії',
					'singular_name' => 'Вакансія',
					'add_new' => 'Додати вакансію',
					'add_new_item' => 'Додати нового вакансію',
					'edit_item' => 'Редактувати вакансію',
					'new_item' => 'Нова вакансія',
					'view_item' => 'Дивитись вакансію',
					'search_items' => 'Шукати вакансію',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-star-filled',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);

		register_post_type(
			'contract',
			[
				'label' => null,
				'labels' => [
					'name' => 'Договори',
					'singular_name' => 'Договір',
					'add_new' => 'Додати договір',
					'add_new_item' => 'Додати новий договір',
					'edit_item' => 'Редактувати договір',
					'new_item' => 'Новий договір',
					'view_item' => 'Дивитись договір',
					'search_items' => 'Шукати договір',
					'not_found' => 'Не знайдено',
					'not_found_in_trash' => 'Не знайдено у кошику',
				],
				'description' => '',
				'public' => true,
				'show_in_menu' => null,
				'show_in_rest' => null,
				'rest_base' => null,
				'menu_position' => null,
				'menu_icon' => 'dashicons-star-filled',
				'hierarchical' => false,
				'supports' => ['title', 'editor', 'custom-fields', 'excerpt'],
				'taxonomies' => ['category'],
				'has_archive' => false,
				'rewrite' => true,
				'query_var' => true,
			]
		);


	}


}

?>