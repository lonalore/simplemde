<?php

/**
 * @file
 * This file is loaded in the "footer" of each page of your site.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/simplemde/languages/[LANGUAGE]/[LANGUAGE]_front.php
e107::lan('simplemde', false, true);


/**
 * Class simplemde_footer.
 */
class simplemde_footer
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

		if(e107::wysiwyg() === true && check_class($this->corePrefs['post_html']))
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

			$settings['l10n'] = array(
				'bold'            => LAN_SIMPLEMDE_EDITOR_01,
				'italic'          => LAN_SIMPLEMDE_EDITOR_02,
				'strikethrough'   => LAN_SIMPLEMDE_EDITOR_03,
				'heading'         => LAN_SIMPLEMDE_EDITOR_04,
				'heading-smaller' => LAN_SIMPLEMDE_EDITOR_05,
				'heading-bigger'  => LAN_SIMPLEMDE_EDITOR_06,
				'heading-1'       => LAN_SIMPLEMDE_EDITOR_07,
				'heading-2'       => LAN_SIMPLEMDE_EDITOR_08,
				'heading-3'       => LAN_SIMPLEMDE_EDITOR_09,
				'code'            => LAN_SIMPLEMDE_EDITOR_10,
				'quote'           => LAN_SIMPLEMDE_EDITOR_11,
				'unordered-list'  => LAN_SIMPLEMDE_EDITOR_12,
				'ordered-list'    => LAN_SIMPLEMDE_EDITOR_13,
				'clean-block'     => LAN_SIMPLEMDE_EDITOR_14,
				'link'            => LAN_SIMPLEMDE_EDITOR_15,
				'image'           => LAN_SIMPLEMDE_EDITOR_16,
				'table'           => LAN_SIMPLEMDE_EDITOR_17,
				'horizontal-rule' => LAN_SIMPLEMDE_EDITOR_18,
				'preview'         => LAN_SIMPLEMDE_EDITOR_19,
				'side-by-side'    => LAN_SIMPLEMDE_EDITOR_20,
				'fullscreen'      => LAN_SIMPLEMDE_EDITOR_21,
				'guide'           => LAN_SIMPLEMDE_EDITOR_22,
				'undo'            => LAN_SIMPLEMDE_EDITOR_23,
				'redo'            => LAN_SIMPLEMDE_EDITOR_24,
				'loading'         => LAN_LOADING,
			);

			// Allow to use Media Manager on Admin UI.
			if(e_ADMIN_AREA)
			{
				// mode=main&action=dialog&for=main&tagid=drawImageValue&iframe=1&video=0
				$query = array(
					'mode'   => 'main',
					'action' => 'dialog',
					'for'    => 'main',
					'tagid'  => 'drawImageValue',
					'iframe' => 1,
					'video'  => 0,
				);

				$url = e_ADMIN_ABS . 'image.php?' . http_build_query($query);

				// Helper attributes for modal-opener.
				$settings['useMediaManager'] = array(
					'data-modal-caption' => 'Media Manager',
					'data-cache'         => 'false',
					'href'               => $url,
				);
			}

			$settings['previewRenderURL'] = e_PLUGIN_ABS . 'simplemde/includes/preview.php';

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


new simplemde_footer();
