<?php

/**
 * @file
 * Provides information about external libraries.
 */


/**
 * Class simplemde_library.
 */
class simplemde_library
{

	/**
	 * Return information about external libraries.
	 */
	function config()
	{
		// SimpleMDE.
		$libraries['simplemde'] = array(
			'name'              => 'SimpleMDE',
			'vendor_url'        => 'https://simplemde.com/',
			'download_url'      => 'https://github.com/NextStepWebs/simplemde-markdown-editor/zipball/master',
			'library_path'      => '{e_PLUGIN}simplemde/vendor/NextStepWebs/simplemde-markdown-editor',
			'path'              => 'dist',
			'version_arguments' => array(
				'file'    => 'simplemde.min.js',
				'pattern' => '/v(\d\.\d+\.\d+)/',
				'lines'   => 5,
			),
			'files'             => array(
				'css' => array(
					'simplemde.min.css' => array(
						'zone' => 2,
					),
				),
				'js'  => array(
					'simplemde.min.js' => array(
						'zone' => 2,
						'type' => 'footer',
					),
				),
			),
		);

		// Highlight.js (CDN)
		$libraries['cdn.highlight.js'] = array(
			'name'              => 'Highlight.js (CDN)',
			'vendor_url'        => 'https://github.com/isagalaev/highlight.js',
			'library_path'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js',
			'path'              => '9.9.0',
			'version_arguments' => array(
				'file'    => 'highlight.min.js',
				'pattern' => '/v(\d\.\d+\.\d+)/',
				'lines'   => 5,
			),
			'files'             => array(
				'css' => array(
					'styles/github.min.css' => array(
						'zone' => 2,
					),
				),
				'js'  => array(
					'highlight.min.js' => array(
						'zone' => 2,
						'type' => 'footer',
					),
				),
			),
		);

		return $libraries;
	}

}
