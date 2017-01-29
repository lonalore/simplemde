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
	);

	/**
	 * @var array
	 */
	protected $prefs = array(

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
