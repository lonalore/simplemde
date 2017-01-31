<?php

/**
 * @file
 * Add-on file to display help block on Admin UI.
 */

if(!defined('e107_INIT'))
{
	exit;
}

// [PLUGINS]/simplemde/languages/[LANGUAGE]/[LANGUAGE]_admin.php
e107::lan('simplemde', true, true);


/**
 * Class simplemde_help.
 */
class simplemde_help
{

	/**
	 * @var mixed
	 */
	private $action;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->action = varset($_GET['action'], '');
		$this->renderHelpBlock();
	}

	/**
	 * Get block contents.
	 */
	public function renderHelpBlock()
	{
		switch($this->action)
		{
			default:
				$block = $this->getHelpBlockDefault();
				break;
		}

		if(!empty($block))
		{
			e107::getRender()->tablerender($block['title'], $block['body']);
		}
	}

	/**
	 * Get default block contents.
	 *
	 * @return array
	 */
	public function getHelpBlockDefault()
	{
		e107::js('footer', 'https://buttons.github.io/buttons.js');

		$content = '';

		$issue = array(
			'href="https://github.com/lonalore/simplemde/issues"',
			'class="github-button"',
			'data-icon="octicon-issue-opened"',
			'data-style="mega"',
			'data-count-api="/repos/lonalore/simplemde#open_issues_count"',
			'data-count-aria-label="# issues on GitHub"',
			'aria-label="Issue lonalore/simplemde on GitHub"',
		);

		$star = array(
			'href="https://github.com/lonalore/simplemde"',
			'class="github-button"',
			'data-icon="octicon-star"',
			'data-style="mega"',
			'data-count-href="/lonalore/simplemde/stargazers"',
			'data-count-api="/repos/lonalore/simplemde#stargazers_count"',
			'data-count-aria-label="# stargazers on GitHub"',
			'aria-label="Star lonalore/simplemde on GitHub"',
		);

		$content .= '<p class="text-center">' . LAN_SIMPLEMDE_ADMIN_HELP_03 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a ' . implode(" ", $issue) . '>' . LAN_SIMPLEMDE_ADMIN_HELP_04 . '</a>';
		$content .= '</p>';

		$content .= '<p class="text-center">' . LAN_SIMPLEMDE_ADMIN_HELP_02 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a ' . implode(" ", $star) . '>' . LAN_SIMPLEMDE_ADMIN_HELP_05 . '</a>';
		$content .= '</p>';

		$beerImage = '<img src="https://beerpay.io/lonalore/simplemde/badge.svg" />';
		$beerWishImage = '<img src="https://beerpay.io/lonalore/simplemde/make-wish.svg" />';

		$content .= '<p class="text-center">' . LAN_SIMPLEMDE_ADMIN_HELP_06 . '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a href="https://beerpay.io/lonalore/simplemde">' . $beerImage . '</a>';
		$content .= '</p>';
		$content .= '<p class="text-center">';
		$content .= '<a href="https://beerpay.io/lonalore/simplemde">' . $beerWishImage . '</a>';
		$content .= '</p>';

		$block = array(
			'title' => LAN_SIMPLEMDE_ADMIN_HELP_01,
			'body'  => $content,
		);

		return $block;
	}

}


new simplemde_help();
