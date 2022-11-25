<?php
namespace goiteens\helper;

class svg_icons
{

	public static function get($icon = '', $classes = array())
	{
		$arr = self::$ui_icons;

		$classes   = (array) $classes;
		$classes[] = 'svg-icon';

		if (array_key_exists($icon, $arr)) {
			$repl = sprintf('<svg class="%s" aria-hidden="true" role="img" focusable="false" ', join(' ', $classes));
			$svg  = preg_replace('/^<svg /', $repl, trim($arr[$icon])); // Add extra attributes to SVG code.
			$svg  = preg_replace("/([\n\t]+)/", ' ', $svg); // Remove newlines & tabs.
			$svg  = preg_replace('/>\s*</', '><', $svg); // Remove white space between SVG tags.

			return $svg;
		}

		return null;
	}

	static $ui_icons = array(
		'logo' => '',
	);
}
