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
					// action: SimpleMDE.drawImage,
					action: settings.simpleMDE['useMediaManager'] ? e107.simpleMDE.drawImage : SimpleMDE.drawImage,
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

				// TODO
				editorConfig.insertTexts = {
					link: ["[", "](#url#)"],
					image: ["![", "](#url#)"],
					table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text     | Text     |\n\n"],
					horizontalRule: ["", "\n\n-----\n\n"]
				};

				editorConfig.previewRender = function (plainText, preview)
				{
					e107.callbacks.waitForFinalEvent(function ()
					{
						e107.simpleMDE.markdownParser(plainText, preview);
					}, 200, "SimpleMDEpreviewRender");

					return settings.simpleMDE.l10n['loading'] || "Loading...";
				};

				e107.simpleMDE[id] = new SimpleMDE(editorConfig);

			});
		}
	};

	/**
	 * Custom function for parsing the plaintext Markdown and returning HTML.
	 *
	 * @param {string} plainText
	 *  Plaintext Markdown.
	 * @param {object} preview
	 *  Element contains preview.
	 *
	 * @returns {String|null|string}
	 */
	e107.simpleMDE.markdownParser = function (plainText, preview)
	{
		var endpoint = e107.settings.simpleMDE['previewRenderURL'];

		$.post(endpoint, {content: plainText}).done(function (data)
		{
			$(preview).html(data);

			if(e107.settings.simpleMDE['codeSyntaxHighlighting'] === true && window.hljs)
			{
				$(preview).find('pre code').each(function ()
				{
					this.innerHTML = window.hljs.highlightAuto(this.innerHTML).value;
				});
			}
		});
	};

	/**
	 * Helper (container) element for:
	 * - e107.simpleMDE.drawImageValueOpener
	 * - e107.simpleMDE.drawImageValueInput
	 *
	 * @see e107.simpleMDE.drawImage
	 *
	 * @type {boolean}
	 */
	e107.simpleMDE.drawImageValueContainer = e107.simpleMDE.drawImageValueContainer || false;

	/**
	 * Helper element for opening modal with Media Manager.
	 *
	 * @see e107.simpleMDE.drawImage
	 *
	 * @type {boolean}
	 */
	e107.simpleMDE.drawImageValueOpener = e107.simpleMDE.drawImageValueOpener || false;

	/**
	 * Helper element for storing Image URL from Media Manager.
	 *
	 * @see e107.simpleMDE.drawImage
	 *
	 * @type {boolean}
	 */
	e107.simpleMDE.drawImageValueInput = e107.simpleMDE.drawImageValueInput || false;

	/**
	 * Helper element for storing Image (preview) URL from Media Manager. This
	 * is only needed for avoidance of errors.
	 *
	 * @see e107.simpleMDE.drawImage
	 *
	 * @type {boolean}
	 */
	e107.simpleMDE.drawImageValueInputPrev = e107.simpleMDE.drawImageValueInputPrev || false;

	/**
	 * Action for drawing an img (with Media Manager support).
	 *
	 * @param {object} editor
	 *  SimpleMDE Editor object.
	 */
	e107.simpleMDE.drawImage = function (editor)
	{
		var config = e107.settings.simpleMDE['useMediaManager'];

		// Assemble helper elements.
		if(e107.simpleMDE.drawImageValueContainer === false)
		{
			e107.simpleMDE.drawImageValueContainer = $('<div id="drawImageValueContainer"></div>');
			e107.simpleMDE.drawImageValueInput = $('<input type="hidden" id="drawImageValue" value=""/>');
			// This is only needed for avoidance of errors...
			e107.simpleMDE.drawImageValueInputPrev = $('<input type="hidden" id="drawImageValue_prev" value=""/>');
			e107.simpleMDE.drawImageValueOpener = $('<a></a>');

			// Set helper attributes on modal opener.
			e107.simpleMDE.drawImageValueOpener.attr('href', config['href']);
			e107.simpleMDE.drawImageValueOpener.attr('class', 'e-modal');
			e107.simpleMDE.drawImageValueOpener.attr('data-modal-caption', config['data-modal-caption']);
			e107.simpleMDE.drawImageValueOpener.attr('data-cache', config['data-cache']);
			e107.simpleMDE.drawImageValueOpener.attr('data-target', '#uiModal');

			// Assemble HTML structure.
			e107.simpleMDE.drawImageValueOpener.appendTo(e107.simpleMDE.drawImageValueContainer);
			e107.simpleMDE.drawImageValueInput.appendTo(e107.simpleMDE.drawImageValueContainer);
			e107.simpleMDE.drawImageValueInputPrev.appendTo(e107.simpleMDE.drawImageValueContainer);

			// Hide container and append it to the body.
			e107.simpleMDE.drawImageValueContainer.css('display', 'none');
			e107.simpleMDE.drawImageValueContainer.appendTo($('body'));

			// Apply "e107.behaviors.eModalAdmin" (and other behaviors) on Opener.
			e107.attachBehaviors(e107.simpleMDE.drawImageValueContainer);
		}

		// Click for opening modal with Media Manager.
		e107.simpleMDE.drawImageValueOpener.click();

		var $modal = $('#uiModal');

		// Add a unique class to modal.
		$modal.addClass('simplemde-drawimage-modal');

		// After the Bootstrap modal dialog is closed.
		$modal.on('hidden.bs.modal', function ()
		{
			var $this = $(this);

			// If this event callback belongs to a Media Manager modal, which was
			// opened from a SimpleMDE Editor.
			if($this.hasClass('simplemde-drawimage-modal'))
			{
				var url = e107.simpleMDE.drawImageValueInput.val();
				var cm = editor.codemirror;
				var stat = e107.simpleMDE.getState(cm);
				var options = editor.options;

				$this.removeClass('simplemde-drawimage-modal');

				if(url == '')
				{
					return false;
				}

				e107.simpleMDE.replaceSelection(cm, stat.image, options.insertTexts.image, url);
			}
		});
	};


	/**
	 * The state of CodeMirror at the given position.
	 */
	e107.simpleMDE.getState = function (cm, pos)
	{
		pos = pos || cm.getCursor("start");

		var stat = cm.getTokenAt(pos);

		if(!stat.type)
		{
			return {};
		}

		var types = stat.type.split(" ");
		var ret = {};
		var data;
		var text;

		for(var i = 0; i < types.length; i++)
		{
			data = types[i];

			if(data === "strong")
			{
				ret.bold = true;
			}
			else if(data === "variable-2")
			{
				text = cm.getLine(pos.line);

				if(/^\s*\d+\.\s/.test(text))
				{
					ret["ordered-list"] = true;
				}
				else
				{
					ret["unordered-list"] = true;
				}
			}
			else if(data === "atom")
			{
				ret.quote = true;
			}
			else if(data === "em")
			{
				ret.italic = true;
			}
			else if(data === "quote")
			{
				ret.quote = true;
			}
			else if(data === "strikethrough")
			{
				ret.strikethrough = true;
			}
			else if(data === "comment")
			{
				ret.code = true;
			}
			else if(data === "link")
			{
				ret.link = true;
			}
			else if(data === "tag")
			{
				ret.image = true;
			}
			else if(data.match(/^header(\-[1-6])?$/))
			{
				ret[data.replace("header", "heading")] = true;
			}
		}

		return ret;
	};

	/**
	 * Overridden function, based on _replaceSelection() from SimpleMDE.
	 */
	e107.simpleMDE.replaceSelection = function (cm, active, startEnd, url)
	{
		if(/editor-preview-active/.test(cm.getWrapperElement().lastChild.className))
		{
			return;
		}

		var text;
		var start = startEnd[0];
		var end = startEnd[1];
		var startPoint = cm.getCursor("start");
		var endPoint = cm.getCursor("end");

		if(url)
		{
			end = end.replace("#url#", url);
		}

		if(active)
		{
			text = cm.getLine(startPoint.line);
			start = text.slice(0, startPoint.ch);
			end = text.slice(startPoint.ch);
			cm.replaceRange(start + end, {
				line: startPoint.line,
				ch: 0
			});
		}
		else
		{
			text = cm.getSelection();
			cm.replaceSelection(start + text + end);

			startPoint.ch += start.length;
			if(startPoint !== endPoint)
			{
				endPoint.ch += start.length;
			}
		}

		cm.setSelection(startPoint, endPoint);
		cm.focus();
	};

})(jQuery);
