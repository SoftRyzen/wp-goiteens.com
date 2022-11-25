<?php
namespace goiteens;

use goiteens\helper\utils;

/**
 * Primary core controller
 **/
class app
{

	private static $instance = null;

	public $config;
	public $model;
	public $view;
	public $controller;

	/**
	 * @return Singleton
	 */
	public static function getInstance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct()
	{
	}

	private function __clone()
	{
	}

	/**
	 * Run the core
	 **/
	public function run()
	{

		session_start();

		// Load default config
		$this->config = require_once get_template_directory() . '/app/config.php';

		// Load core classes
		$this->_dispatch();

	}

	/**
	 * Load and instantiate all application
	 * classes neccessary for this theme
	 **/
	private function _dispatch()
	{

		$this->model = new \stdClass();
		$this->view = new \stdClass();
		$this->controller = new \stdClass();

		// Autoload models
		$this->_load_modules('model', '/');

		// Init view
		$this->view = new \goiteens\view\view();

		// Load controllers manually
		$controllers = [
			'acf',
			'init',
			'widgets',
			'backend',
			'frontend',
			'optimization',
			'blog',
		];

		$this->_load_controllers($controllers);

	}

	/**
	 * Autoload core modules in a specific directory
	 *
	 * @param string
	 * @param string
	 * @param bool
	 **/
	private function _load_modules($layer, $dir = '/')
	{

		$directory = get_template_directory() . '/app/' . $layer . $dir;
		$handle = opendir($directory);

		if (count(glob("$directory/*")) === 0) {
			return false;
		}

		while (false !== ($file = readdir($handle))) {

			if (is_file($directory . $file)) {

				// Figure out class name from file name
				$class = str_replace('.php', '', $file);

				// Avoid recursion
				if ($class !== get_class($this)) {
					$classPath = "\\goiteens\\{$layer}\\{$class}";
					$this->$layer->$class = new $classPath();
				}

			}
		}

	}

	/**
	 * Autoload controllers in specific order
	 */
	private function _load_controllers($list)
	{

		$directory = get_template_directory() . '/app/controller/';

		foreach ($list as $controller_name) {

			if (is_file($directory . $controller_name . '.php')) {
				$class = $controller_name;

				// Avoid recursion
				if ($class !== get_class($this)) {
					$classPath = "\\goiteens\\controller\\{$class}";
					$this->controller->$controller_name = new $classPath();
				}
			}
		}

	}

}
?>