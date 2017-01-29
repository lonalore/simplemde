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
				var $element = $(this);
				var $form = $element.closest('form');
				var content = $element.html();

				// Remove bbcode from initial value.
				content = content.replace('[markdown]', '');
				content = content.replace('[/markdown]', '');

				// Update initial value.
				$element.html(content);

				var id = $element.attr('id');

				$('#bbcode-panel-' + id + '--preview').hide();

				// TODO admin prefs for customizing editor...
				e107.simpleMDE[id] = new SimpleMDE({
					element: this,
					showIcons: ["code", "table"],
					promptURLs: true,
					styleSelectedText: false,
					autoDownloadFontAwesome: false
				});

				$form.submit(function() {
					// FIXME ... do this on backend!
					e107.simpleMDE[id].value('[markdown]' + e107.simpleMDE[id].value() + '[/markdown]');
				});
			});
		}
	};

})(jQuery);
