<?php

/**
 * @file
 * This file is loaded in the header of each page of your site.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/simplemde/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('simplemde', false, true);


/**
 * Class simplemde_header.
 */
class simplemde_header
{

	/**
	 * Plugin preferences.
	 *
	 * @var array
	 */
	private $plugPrefs = array();

	/**
	 * Core preferences.
	 *
	 * @var array
	 */
	private $corePrefs = array();

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->plugPrefs = e107::getPlugConfig('simplemde')->getPref();
		$this->corePrefs = e107::getPref();

		// FIXME - load files only when editor is in use...
		if(check_class($this->corePrefs['post_html']))
		{
			$this->loadSimpleMDE();
		}
	}

	/**
	 * Load SimpleMDE files.
	 */
	public function loadSimpleMDE()
	{
		if(($library = e107::library('load', 'simplemde')) && !empty($library['loaded']))
		{
			$settings = array(
				'autofocus'                  => (bool) varset($this->plugPrefs['autofocus'], 0),
				'autosaveEnabled'            => (bool) varset($this->plugPrefs['autosaveEnabled'], 0),
				'autosaveDelay'              => (int) varset($this->plugPrefs['autosaveDelay'], 10000),
				'forceSync'                  => (bool) varset($this->plugPrefs['forceSync'], 0),
				'indentWithTabs'             => (bool) varset($this->plugPrefs['indentWithTabs'], 1),
				'initialValue'               => varset($this->plugPrefs['initialValue'], ''),
				'lineWrapping'               => (bool) varset($this->plugPrefs['lineWrapping'], 1),
				'allowAtxHeaderWithoutSpace' => (bool) varset($this->plugPrefs['allowAtxHeaderWithoutSpace'], 0),
				'strikethrough'              => (bool) varset($this->plugPrefs['strikethrough'], 1),
				'underscoresBreakWords'      => (bool) varset($this->plugPrefs['underscoresBreakWords'], 0),
				'placeholder'                => varset($this->plugPrefs['placeholder'], ''),
				'promptURLs'                 => (bool) varset($this->plugPrefs['promptURLs'], 0),
				'singleLineBreaks'           => (bool) varset($this->plugPrefs['singleLineBreaks'], 0),
				'codeSyntaxHighlighting'     => (bool) varset($this->plugPrefs['codeSyntaxHighlighting'], 0),
				'spellChecker'               => (bool) varset($this->plugPrefs['spellChecker'], 0),
				'styleSelectedText'          => (bool) varset($this->plugPrefs['styleSelectedText'], 1),
				'tabSize'                    => (int) varset($this->plugPrefs['tabSize'], 2),
				'toolbarTips'                => (bool) varset($this->plugPrefs['toolbarTips'], 1),

				// Shortcuts.
				'toggleBold'                 => varset($this->plugPrefs['toggleBold'], ''),
				'toggleItalic'               => varset($this->plugPrefs['toggleItalic'], ''),
				'drawLink'                   => varset($this->plugPrefs['drawLink'], ''),
				'toggleHeadingSmaller'       => varset($this->plugPrefs['toggleHeadingSmaller'], ''),
				'toggleHeadingBigger'        => varset($this->plugPrefs['toggleHeadingBigger'], ''),
				'cleanBlock'                 => varset($this->plugPrefs['cleanBlock'], ''),
				'drawImage'                  => varset($this->plugPrefs['drawImage'], ''),
				'toggleBlockquote'           => varset($this->plugPrefs['toggleBlockquote'], ''),
				'toggleOrderedList'          => varset($this->plugPrefs['toggleOrderedList'], ''),
				'toggleUnorderedList'        => varset($this->plugPrefs['toggleUnorderedList'], ''),
				'toggleCodeBlock'            => varset($this->plugPrefs['toggleCodeBlock'], ''),
				'togglePreview'              => varset($this->plugPrefs['togglePreview'], ''),
				'toggleSideBySide'           => varset($this->plugPrefs['toggleSideBySide'], ''),
				'toggleFullScreen'           => varset($this->plugPrefs['toggleFullScreen'], ''),
			);

			if((int) varset($this->plugPrefs['autoDownloadFontAwesome'], 0) < 2)
			{
				$settings['autoDownloadFontAwesome'] = (bool) $this->plugPrefs['autoDownloadFontAwesome'];
			}

			if((bool) varset($this->plugPrefs['codeSyntaxHighlighting'], 0) === true)
			{
				e107::library('load', 'cdn.highlight.js');
			}

			e107::js('settings', array('simpleMDE' => $settings));
			e107::js('simplemde', 'js/simplemde.init.js');

			e107::css('simplemde', 'css/simplemde.init.css');
		}

	}

}


new simplemde_header();
