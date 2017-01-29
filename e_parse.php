<?php

/**
 * @file
 * Addon file for extending e_parser.
 */

if(!defined('e107_INIT'))
{
	exit;
}


/**
 * Class simplemde_parse.
 */
class simplemde_parse
{

	/**
	 * Constructor.
	 */
	function __construct()
	{


	}

	/**
	 * @param string $text
	 *  HTML/text to be processed.
	 * @param string $context
	 *  Current context ie:
	 *  OLDDEFAULT | BODY | TITLE | SUMMARY | DESCRIPTION | WYSIWYG
	 *
	 * @return string
	 */
	function toHtml($text, $context = '')
	{
		return $text;
	}

	/**
	 * @param string $text
	 *  HTML/text to be processed.
	 * @param array $param
	 *
	 * @return string
	 */
	function toDB($text, $param = array())
	{
		$type = varset($param['type'], '');
		$field = varset($param['field'], '');

		if($type == 'bbarea')
		{
			return '[markdown]' . $text . '[/markdown]';
		}

		$fields = array(
			'news_body',
			'news_extended',
		);

		if(in_array($field, $fields) && $type == 'method')
		{
			return '[markdown]' . $text . '[/markdown]';
		}

		return $text;
	}

}
