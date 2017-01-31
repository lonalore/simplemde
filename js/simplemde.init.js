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
			settings.simpleMDE = settings.simpleMDE || [];

			$(context).find('.e-wysiwyg').once('simplemde').each(function ()
			{
				var $element = $(this);
				var content = $element.html();

				// Remove bbcode from initial value.
				content = content.replace('[markdown]', '');
				content = content.replace('[/markdown]', '');
				// Update initial value.
				$element.html(content);

				var id = $element.attr('id');

				$('#bbcode-panel-' + id + '--preview').hide();

				var editorConfig = {
					element: this,
					autofocus: settings.simpleMDE['autofocus'] || false,
					autosave: {
						enabled: settings.simpleMDE['autosaveEnabled'] || false,
						uniqueId: id,
						delay: settings.simpleMDE['autosaveDelay'] || false
					},
					forceSync: settings.simpleMDE['forceSync'] || false,
					indentWithTabs: settings.simpleMDE['indentWithTabs'] || true,
					initialValue: settings.simpleMDE['initialValue'] || "",
					lineWrapping: settings.simpleMDE['lineWrapping'] || false,
					parsingConfig: {
						allowAtxHeaderWithoutSpace: settings.simpleMDE['allowAtxHeaderWithoutSpace'] || true,
						strikethrough: settings.simpleMDE['strikethrough'] || false,
						underscoresBreakWords: settings.simpleMDE['underscoresBreakWords'] || true
					},
					placeholder: settings.simpleMDE['placeholder'] || "",
					promptURLs: settings.simpleMDE['promptURLs'] || false,
					renderingConfig: {
						singleLineBreaks: settings.simpleMDE['singleLineBreaks'] || true,
						codeSyntaxHighlighting: settings.simpleMDE['codeSyntaxHighlighting'] || false
					},
					spellChecker: settings.simpleMDE['spellChecker'] || true,
					styleSelectedText: settings.simpleMDE['styleSelectedText'] || true,
					tabSize: settings.simpleMDE['tabSize'] || 2,
					toolbarTips: settings.simpleMDE['toolbarTips'] || true,
					hideIcons: [], // TODO
					showIcons: ["code", "table"] // TODO
				};

				if(settings.simpleMDE['autoDownloadFontAwesome'])
				{
					editorConfig.autoDownloadFontAwesome = settings.simpleMDE['autoDownloadFontAwesome'];
				}

				editorConfig.shortcuts = {
					toggleBold: settings.simpleMDE['toggleBold'] || null,
					toggleItalic: settings.simpleMDE['toggleItalic'] || null,
					drawLink: settings.simpleMDE['drawLink'] || null,
					toggleHeadingSmaller: settings.simpleMDE['toggleHeadingSmaller'] || null,
					toggleHeadingBigger: settings.simpleMDE['toggleHeadingBigger'] || null,
					cleanBlock: settings.simpleMDE['cleanBlock'] || null,
					drawImage: settings.simpleMDE['drawImage'] || null,
					toggleBlockquote: settings.simpleMDE['toggleBlockquote'] || null,
					toggleOrderedList: settings.simpleMDE['toggleOrderedList'] || null,
					toggleUnorderedList: settings.simpleMDE['toggleUnorderedList'] || null,
					toggleCodeBlock: settings.simpleMDE['toggleCodeBlock'] || null,
					togglePreview: settings.simpleMDE['togglePreview'] || null,
					toggleSideBySide: settings.simpleMDE['toggleSideBySide'] || null,
					toggleFullScreen: settings.simpleMDE['toggleFullScreen'] || null
				};

				e107.simpleMDE[id] = new SimpleMDE(editorConfig);

			});
		}
	};

})(jQuery);
