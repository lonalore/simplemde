/**
 * @file
 * SimpleMDE implementation.
 */

var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{
	'use strict';

	e107.simpleMDE = e107.simpleMDE || {};

	/**
	 * Behavior to initialize SimpleMDE editor.
	 *
	 * @type {{attach: e107.behaviors.simpleMDE.attach}}
	 */
	e107.behaviors.simpleMDE = {
		attach: function (context, settings)
		{
			$(context).find('.e-wysiwyg').once('simplemde').each(function ()
			{
				var simpleMDE = new SimpleMDE({element: this});

				e107.simpleMDE.push(simpleMDE);
			});
		}
	};

})(jQuery);
