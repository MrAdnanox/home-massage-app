(function (blocks, i18n, blockEditor, components) {
	var el = wp.element.createElement;
	var __ = i18n.__;
	var useBlockProps = blockEditor.useBlockProps;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody = components.PanelBody;
	var SelectControl = components.SelectControl;

	// Get languages from PHP (passed via wp_add_inline_script)
	var availableLanguages = window.mpeReservationFormLanguages || [
		{ label: 'English', value: 'en' },
		{ label: 'Français', value: 'fr' },
	];

	// Create title mappings for preview
	var titleMappings = {
		'en': 'GET A FREE QUOTE',
		'fr': 'DEMANDEZ UN DEVIS GRATUIT',
		'es': 'SOLICITA UN PRESUPUESTO GRATIS',
		'de': 'KOSTENLOSES ANGEBOT ANFORDERN',
		'it': 'RICHIEDI UN PREVENTIVO GRATUITO',
		'pt': 'PEÇA UM ORÇAMENTO GRÁTIS',
		'nl': 'VRAAG EEN GRATIS OFFERTE AAN',
		'ar': 'احصل على عرض سعر مجاني',
	};

	blocks.registerBlockType('mpe2025/reservation-form', {
		edit: function (props) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;
			var blockProps = useBlockProps();

			// Get preview title based on selected language
			var previewTitle = titleMappings[attributes.language] || titleMappings['en'];

			return el(
				wp.element.Fragment,
				{},
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{ title: __('Form Settings', 'mpe2025'), initialOpen: true },
						el(SelectControl, {
							label: __('Language', 'mpe2025'),
							help: __('Select the language for this form. Language-specific labels can be configured in Theme Options.', 'mpe2025'),
							value: attributes.language,
							options: availableLanguages,
							onChange: function (value) { setAttributes({ language: value }); },
						})
					)
				),
				el(
					'div',
					blockProps,
					el('div', { className: 'mpe-reservation-form-placeholder' },
						el('h3', {}, previewTitle),
						el('p', {}, __('Reservation Form', 'mpe2025')),
						el('small', { style: { color: '#666', display: 'block', marginTop: '10px' } },
							__('Note: Form will automatically display in the current page language when using Polylang.', 'mpe2025')
						)
					)
				)
			);
		},
	});
})(window.wp.blocks, window.wp.i18n, window.wp.blockEditor, window.wp.components);
