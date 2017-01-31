/**
 * @file
 * SimpleMDE implementation of {@link e107.behaviors} API.
 */

var e107 = e107 || {'settings': {}, 'behaviors': {}};

(function ($)
{
	'use strict';

	/**
	 * @type {{}}
	 */
	e107.simpleMDE = e107.simpleMDE || {};

	/**
	 * Behavior to initialize SimpleMDE editor.
	 *
	 * @type {{attach: e107.behaviors.simpleMDE.attach}}
	 */
	e107.behaviors.simpleMDE = {
		attach: function (context, settings)
		{
			/**
			 * @type {Array}
			 */
			settings.simpleMDE = settings.simpleMDE || [];

			/**
			 * @type {Array}
			 */
			settings.simpleMDE.l10n = settings.simpleMDE.l10n || [];

			/**
			 * @type {*[]}
			 */
			settings.simpleMDE.toolbarButtons = [
				{
					name: "bold",
					action: SimpleMDE.toggleBold,
					className: "fa fa-bold",
					title: settings.simpleMDE.l10n['bold'] || "Bold"
				},
				{
					name: "italic",
					action: SimpleMDE.toggleItalic,
					className: "fa fa-italic",
					title: settings.simpleMDE.l10n['italic'] || "Italic"
				},
				{
					name: "strikethrough",
					action: SimpleMDE.toggleStrikethrough,
					className: "fa fa-strikethrough",
					title: settings.simpleMDE.l10n['strikethrough'] || "Strikethrough"
				},
				{
					name: "heading",
					action: SimpleMDE.toggleHeadingSmaller,
					className: "fa fa-header",
					title: settings.simpleMDE.l10n['heading'] || "Heading"
				},
				{
					name: "heading-smaller",
					action: SimpleMDE.toggleHeadingSmaller,
					className: "fa fa-header fa-header-x fa-header-smaller",
					title: settings.simpleMDE.l10n['heading-smaller'] || "Smaller Heading"
				},
				{
					name: "heading-bigger",
					action: SimpleMDE.toggleHeadingBigger,
					className: "fa fa-header fa-header-x fa-header-bigger",
					title: settings.simpleMDE.l10n['heading-bigger'] || "Bigger Heading"
				},
				{
					name: "heading-1",
					action: SimpleMDE.toggleHeading1,
					className: "fa fa-header fa-header-x fa-header-1",
					title: settings.simpleMDE.l10n['heading-1'] || "Big Heading"
				},
				{
					name: "heading-2",
					action: SimpleMDE.toggleHeading2,
					className: "fa fa-header fa-header-x fa-header-2",
					title: settings.simpleMDE.l10n['heading-2'] || "Medium Heading"
				},
				{
					name: "heading-3",
					action: SimpleMDE.toggleHeading3,
					className: "fa fa-header fa-header-x fa-header-3",
					title: settings.simpleMDE.l10n['heading-3'] || "Small Heading"
				},
				"|",
				{
					name: "code",
					action: SimpleMDE.toggleCodeBlock,
					className: "fa fa-code",
					title: settings.simpleMDE.l10n['code'] || "Code"
				},
				{
					name: "quote",
					action: SimpleMDE.toggleBlockquote,
					className: "fa fa-quote-left",
					title: settings.simpleMDE.l10n['quote'] || "Quote"
				},
				{
					name: "unordered-list",
					action: SimpleMDE.toggleUnorderedList,
					className: "fa fa-list-ul",
					title: settings.simpleMDE.l10n['unordered-list'] || "Generic List"
				},
				{
					name: "ordered-list",
					action: SimpleMDE.toggleOrderedList,
					className: "fa fa-list-ol",
					title: settings.simpleMDE.l10n['ordered-list'] || "Numbered List"
				},
				{
					name: "clean-block",
					action: SimpleMDE.cleanBlock,
					className: "fa fa-eraser fa-clean-block",
					title: settings.simpleMDE.l10n['clean-block'] || "Clean block"
				},
				"|",
				{
					name: "link",
					action: SimpleMDE.drawLink,
					className: "fa fa-link",
					title: settings.simpleMDE.l10n['link'] || "Create Link"
				},
				{
					name: "image",
					action: SimpleMDE.drawImage,
					className: "fa fa-picture-o",
					title: settings.simpleMDE.l10n['image'] || "Insert Image"
				},
				{
					name: "table",
					action: SimpleMDE.drawTable,
					className: "fa fa-table",
					title: settings.simpleMDE.l10n['table'] || "Insert Table"
				},
				{
					name: "horizontal-rule",
					action: SimpleMDE.drawHorizontalRule,
					className: "fa fa-minus",
					title: settings.simpleMDE.l10n['horizontal-rule'] || "Insert Horizontal Line"
				},
				"|",
				{
					name: "preview",
					action: SimpleMDE.togglePreview,
					className: "fa fa-eye no-disable",
					title: settings.simpleMDE.l10n['preview'] || "Toggle Preview"
				},
				{
					name: "side-by-side",
					action: SimpleMDE.toggleSideBySide,
					className: "fa fa-columns no-disable no-mobile",
					title: settings.simpleMDE.l10n['side-by-side'] || "Toggle Side by Side"
				},
				{
					name: "fullscreen",
					action: SimpleMDE.toggleFullScreen,
					className: "fa fa-arrows-alt no-disable no-mobile",
					title: settings.simpleMDE.l10n['fullscreen'] || "Toggle Fullscreen"
				},
				"|",
				{
					name: "guide",
					action: "https://simplemde.com/markdown-guide",
					className: "fa fa-question-circle",
					title: settings.simpleMDE.l10n['guide'] || "Markdown Guide"
				},
				"|",
				{
					name: "undo",
					action: SimpleMDE.undo,
					className: "fa fa-undo no-disable",
					title: settings.simpleMDE.l10n['undo'] || "Undo"
				},
				{
					name: "redo",
					action: SimpleMDE.redo,
					className: "fa fa-repeat no-disable",
					title: settings.simpleMDE.l10n['redo'] || "Redo"
				}
			];

			/**
			 * Initializes SimpleMDE editor on ".e-wysiwyg" elements.
			 */
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
					toolbar: settings.simpleMDE.toolbarButtons,
					hideIcons: [], // TODO
					showIcons: [] // TODO
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

	/**
	 *  TODO...
	 *
	 * Action for drawing an img (with Media Manager support).
	 */
	e107.simpleMDE.drawImage = function (editor)
	{
		var cm = editor.codemirror;
		var stat = SimpleMDE.getState(cm);
		var options = editor.options;
		var url = "http://";

		if(options.promptURLs)
		{
			url = SimpleMDE.prompt(options.promptTexts.image);

			// TODO - magic... for media-manager.

			if(!url)
			{
				return false;
			}
		}

		SimpleMDE._replaceSelection(cm, stat.image, options.insertTexts.image, url);
	}

})(jQuery);
