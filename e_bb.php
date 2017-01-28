<?php

/**
 * @file
 * Contains class for [markdown] bbcode.
 */

if(!defined('e107_INIT'))
{
	exit;
}


/**
 * Class simplemde_bb.
 */
class simplemde_bb extends e_bb_base
{

	/**
	 * Called prior to save. Re-assemble the bbcode.
	 */
	function toDB($text, $parm)
	{
		return '[markdown]' . $text . '[/markdown]';
	}

	/**
	 * Translate Markdown text into the appropriate HTML.
	 */
	function toHTML($text, $parm)
	{
		e107_require_once(e_PLUGIN . 'simplemde/includes/parsedown.php');

		$Parsedown = new e107Parsedown();

		return $Parsedown->text($text);
	}

}
