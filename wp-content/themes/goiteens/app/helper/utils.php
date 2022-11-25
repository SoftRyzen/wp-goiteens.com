<?php
namespace goiteens\helper;

class utils
{

	/**
	 * Autoload PHP files in directory
	 *
	 * @param $dir
	 * @param int $max_scan_depth
	 * @param string $load_file
	 * @param int $current_depth
	 */
	public static function autoload_dir($dir, $max_scan_depth = 0, $load_file = '', $current_depth = 0)
	{
		if ($current_depth > $max_scan_depth) {
			return;
		}
		// require all php files
		$scan = glob(trailingslashit($dir) . '*');
		foreach ($scan as $path) {
			if (preg_match('/\.php$/', $path)) {
				if (is_string($load_file) && $load_file !== '') {
					// load specific file
					$dir = dirname($path);
					$file = $dir . '/' . $load_file;
					if (is_file($file)) {
						require_once $file;
					}
				} else {
					// load all PHP files in folder
					require_once $path;
				}
			} elseif (is_dir($path)) {
				self::autoload_dir($path, $max_scan_depth, $load_file, $current_depth + 1);
			}
		}
	}

	/**
	 * Verify AJAX nonce
	 */
	public static function verify_ajax_request()
	{

		if (!wp_verify_nonce($_REQUEST['nonce'], 'goiteens_ajax_nonce')) {
			die('AJAX request was not validated');
		}

	}

}

?>