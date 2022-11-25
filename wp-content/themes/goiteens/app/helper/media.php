<?php
namespace goiteens\helper;

if (!class_exists('Aq_Resize')) {
	require_once get_template_directory() . '/vendor-custom/aq_resizer/aq_resizer.php';
}

class media
{

	/**
	 * Get image aspect ratio
	 */
	public static function get_aspect_ratio($a, $b)
	{

		if ($b == 1) {
			$b = $a;
		}

		$gcd = function ($a, $b) use (&$gcd) {
			return ($a % $b) ? $gcd($b, $a % $b) : $b;
		};
		$g = $gcd($a, $b);
		return round((100 / ($a / $g)) * ($b / $g), 2);
	}

	/**
	 * Check if attachment if SVG
	 */
	public static function is_attachment_svg($attachment_id_or_url)
	{

		$is_attachment_svg_by_mime = $is_attachment_svg_by_ext = false;

		if (is_numeric($attachment_id_or_url)) {
			$mime = \get_post_mime_type($attachment_id_or_url);
			$is_attachment_svg_by_mime = ($mime === 'image/svg+xml');
		} else {
			$path = parse_url($attachment_id_or_url, PHP_URL_PATH);
			$extension = pathinfo($path, PATHINFO_EXTENSION);
			$is_attachment_svg_by_ext = (strtolower($extension) === 'svg');
		}

		return $is_attachment_svg_by_mime || $is_attachment_svg_by_ext;
	}

	/**
	 * Simply resize image
	 */
	public static function get_img_resized($url, $width, $height)
	{

		$src = \aq_resize($url, $width, $height, true);
		return self::is_attachment_svg($url) ? $url : \aq_resize($url, $width, $height, true);

	}

}

?>