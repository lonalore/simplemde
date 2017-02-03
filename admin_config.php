<?php

/**
 * @file
 * Admin UI.
 */

require_once("../../class2.php");

if(!e107::isInstalled('simplemde') || !getperms("P"))
{
	e107::redirect(e_BASE . 'index.php');
}

// [PLUGINS]/simplemde/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('simplemde', true, true);


/**
 * Class simplemde_admin_config.
 */
class simplemde_admin_config extends e_admin_dispatcher
{

	/**
	 * Required (set by child class).
	 *
	 * Controller map array in format.
	 * @code
	 *  'MODE' => array(
	 *      'controller' =>'CONTROLLER_CLASS_NAME',
	 *      'path' => 'CONTROLLER SCRIPT PATH',
	 *      'ui' => 'UI_CLASS', // extend of 'comments_admin_form_ui'
	 *      'uipath' => 'path/to/ui/',
	 *  );
	 * @endcode
	 *
	 * @var array
	 */
	protected $modes = array(
		'main' => array(
			'controller' => 'simplemde_admin_ui',
			'path'       => null,
			'ui'         => 'simplemde_admin_form_ui',
			'uipath'     => null
		),
	);

	/**
	 * Optional (set by child class).
	 *
	 * Required for admin menu render. Format:
	 * @code
	 *  'mode/action' => array(
	 *      'caption' => 'Link title',
	 *      'perm' => '0',
	 *      'url' => '{e_PLUGIN}plugname/admin_config.php',
	 *      ...
	 *  );
	 * @endcode
	 *
	 * Note that 'perm' and 'userclass' restrictions are inherited from the $modes, $access and $perm, so you don't
	 * have to set that vars if you don't need any additional 'visual' control.
	 *
	 * All valid key-value pair (see e107::getNav()->admin function) are accepted.
	 *
	 * @var array
	 */
	protected $adminMenu = array(
		'main/prefs' => array(
			'caption' => LAN_SIMPLEMDE_ADMIN_NAV_01,
			'perm'    => 'P',
		),
	);

	/**
	 * Optional (set by child class).
	 *
	 * @var string
	 */
	protected $menuTitle = LAN_PLUGIN_SIMPLEMDE_NAME;

}


/**
 * Class metatag_admin_ui.
 */
class simplemde_admin_ui extends e_admin_ui
{

	/**
	 * Could be LAN constant (multi-language support).
	 *
	 * @var string plugin name
	 */
	protected $pluginTitle = LAN_PLUGIN_SIMPLEMDE_NAME;

	/**
	 * Plugin name.
	 *
	 * @var string
	 */
	protected $pluginName = "simplemde";

	/**
	 * @var array
	 */
	protected $preftabs = array(
		LAN_SIMPLEMDE_ADMIN_TAB_01,
		LAN_SIMPLEMDE_ADMIN_TAB_02,
		LAN_SIMPLEMDE_ADMIN_TAB_03,
	);

	/**
	 * @var array
	 */
	protected $prefs = array(
		'enableEditor'               => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_54,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				1 => LAN_SIMPLEMDE_ADMIN_55,
				2 => LAN_SIMPLEMDE_ADMIN_56,
				3 => LAN_SIMPLEMDE_ADMIN_57,
			),
			'tab'        => 0,
		),
		'eToken'                     => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_53,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 0,
		),
		'autoDownloadFontAwesome'    => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_01,
			'help'       => LAN_SIMPLEMDE_ADMIN_02,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
				2 => LAN_SIMPLEMDE_ADMIN_OPT_03,
			),
			'tab'        => 1,
		),
		'autofocus'                  => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_03,
			'help'       => LAN_SIMPLEMDE_ADMIN_04,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'autosaveEnabled'            => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_05,
			'help'       => LAN_SIMPLEMDE_ADMIN_06,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'autosaveDelay'              => array(
			'title' => LAN_SIMPLEMDE_ADMIN_07,
			'help'  => LAN_SIMPLEMDE_ADMIN_08,
			'type'  => 'number',
			'tab'   => 1,
		),
		'forceSync'                  => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_09,
			'help'       => LAN_SIMPLEMDE_ADMIN_10,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'indentWithTabs'             => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_11,
			'help'       => LAN_SIMPLEMDE_ADMIN_12,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'tabSize'                    => array(
			'title' => LAN_SIMPLEMDE_ADMIN_35,
			'help'  => LAN_SIMPLEMDE_ADMIN_36,
			'type'  => 'number',
			'tab'   => 1,
		),
		'lineWrapping'               => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_15,
			'help'       => LAN_SIMPLEMDE_ADMIN_16,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'allowAtxHeaderWithoutSpace' => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_17,
			'help'       => LAN_SIMPLEMDE_ADMIN_18,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'strikethrough'              => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_19,
			'help'       => LAN_SIMPLEMDE_ADMIN_20,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'underscoresBreakWords'      => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_21,
			'help'       => LAN_SIMPLEMDE_ADMIN_22,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'promptURLs'                 => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_25,
			'help'       => LAN_SIMPLEMDE_ADMIN_26,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'singleLineBreaks'           => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_27,
			'help'       => LAN_SIMPLEMDE_ADMIN_28,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'codeSyntaxHighlighting'     => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_29,
			'help'       => LAN_SIMPLEMDE_ADMIN_30,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'spellChecker'               => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_31,
			'help'       => LAN_SIMPLEMDE_ADMIN_32,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'styleSelectedText'          => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_33,
			'help'       => LAN_SIMPLEMDE_ADMIN_34,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'toolbarTips'                => array(
			'title'      => LAN_SIMPLEMDE_ADMIN_37,
			'help'       => LAN_SIMPLEMDE_ADMIN_38,
			'type'       => 'dropdown',
			'data'       => 'int',
			'writeParms' => array(
				0 => LAN_SIMPLEMDE_ADMIN_OPT_02,
				1 => LAN_SIMPLEMDE_ADMIN_OPT_01,
			),
			'tab'        => 1,
		),
		'initialValue'               => array(
			'title' => LAN_SIMPLEMDE_ADMIN_13,
			'help'  => LAN_SIMPLEMDE_ADMIN_14,
			'type'  => 'text',
			'tab'   => 1,
		),
		'placeholder'                => array(
			'title' => LAN_SIMPLEMDE_ADMIN_23,
			'help'  => LAN_SIMPLEMDE_ADMIN_24,
			'type'  => 'text',
			'tab'   => 1,
		),
		'toggleBold'                 => array(
			'title' => LAN_SIMPLEMDE_ADMIN_39,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleItalic'               => array(
			'title' => LAN_SIMPLEMDE_ADMIN_40,
			'type'  => 'text',
			'tab'   => 2,
		),
		'drawLink'                   => array(
			'title' => LAN_SIMPLEMDE_ADMIN_41,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleHeadingSmaller'       => array(
			'title' => LAN_SIMPLEMDE_ADMIN_42,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleHeadingBigger'        => array(
			'title' => LAN_SIMPLEMDE_ADMIN_43,
			'type'  => 'text',
			'tab'   => 2,
		),
		'cleanBlock'                 => array(
			'title' => LAN_SIMPLEMDE_ADMIN_44,
			'type'  => 'text',
			'tab'   => 2,
		),
		'drawImage'                  => array(
			'title' => LAN_SIMPLEMDE_ADMIN_45,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleBlockquote'           => array(
			'title' => LAN_SIMPLEMDE_ADMIN_46,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleOrderedList'          => array(
			'title' => LAN_SIMPLEMDE_ADMIN_47,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleUnorderedList'        => array(
			'title' => LAN_SIMPLEMDE_ADMIN_48,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleCodeBlock'            => array(
			'title' => LAN_SIMPLEMDE_ADMIN_49,
			'type'  => 'text',
			'tab'   => 2,
		),
		'togglePreview'              => array(
			'title' => LAN_SIMPLEMDE_ADMIN_50,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleSideBySide'           => array(
			'title' => LAN_SIMPLEMDE_ADMIN_51,
			'type'  => 'text',
			'tab'   => 2,
		),
		'toggleFullScreen'           => array(
			'title' => LAN_SIMPLEMDE_ADMIN_52,
			'type'  => 'text',
			'tab'   => 2,
		),
	);

}


/**
 * Class metatag_admin_form_ui.
 */
class simplemde_admin_form_ui extends e_admin_form_ui
{

}


new simplemde_admin_config();

require_once(e_ADMIN . "auth.php");
e107::getAdminUI()->runPage();
require_once(e_ADMIN . "footer.php");
exit;
