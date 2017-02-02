<?php

/**
 * @file
 * Preview handler for SimpleMDE editors.
 */

if(!defined('e107_INIT'))
{
	require_once('../../../class2.php');
}

if(!e107::isInstalled('simplemde'))
{
	exit;
}

// Default output.
$html = '';

if(!empty($_POST['content']))
{
	e107_require_once(e_PLUGIN . 'simplemde/includes/parsedown.php');

	$Parsedown = new e107Parsedown();

	$html = $Parsedown->text($_POST['content']);
	$html = e107::getParser()->replaceConstants($html, 'full');
}

print $html;
exit;
