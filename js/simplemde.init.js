/**
 * @file
 * SimpleMDE implementation.
 */

var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{
	'use strict';

	e107.simpleMDE = e107.simpleMDE || [];

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
				var $this = $(this);
				var id = $this.attr('id');

				$('#bbcode-panel-' + id + '--preview').hide();

				new SimpleMDE({element: this})
			});
		}
	};

})(jQuery);
