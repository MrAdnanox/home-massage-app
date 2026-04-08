(function (blocks, element, blockEditor, components) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var useBlockProps = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var MediaUpload = blockEditor.MediaUpload;
    var PanelBody = components.PanelBody;
    var Button = components.Button;
    var RangeControl = components.RangeControl;

    registerBlockType('mpe2025/custom-gallery', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var images = attributes.images || [];
            var columns = attributes.columns || 3;
            var blockProps = useBlockProps({
                className: 'custom-gallery-editor'
            });

            var onSelectImages = function (newImages) {
                // Filter to ensure we have valid image data
                var updatedImages = newImages.map(function (img) {
                    return {
                        id: img.id,
                        url: img.url,
                        alt: img.alt,
                        sizes: img.sizes
                    };
                });

                // If appending is desired, logic could be different, 
                // but usually galleries replace or add to selection. 
                // Here we just replace for simplicity or we could append.
                // Let's implement append logic if needed, but MediaUpload 'gallery' output basically handles selection state.
                setAttributes({ images: updatedImages });
            };

            // Render the gallery grid in editor
            var renderGallery = function () {
                if (images.length === 0) {
                    return el('div', { className: 'components-placeholder__label' }, 'No images selected.');
                }

                return el('div', {
                    className: 'custom-gallery-grid',
                    style: { display: 'grid', gridTemplateColumns: 'repeat(' + columns + ', 1fr)', gap: '10px' }
                }, images.map(function (img) {
                    return el('div', { key: img.id, className: 'gallery-item-preview' },
                        el('img', {
                            src: (img.sizes && img.sizes.thumbnail) ? img.sizes.thumbnail.url : img.url,
                            alt: img.alt,
                            style: { width: '100%', height: 'auto', display: 'block' }
                        })
                    );
                }));
            };

            return el(
                'div',
                blockProps,
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Gallery Settings', initialOpen: true },
                        el(RangeControl, {
                            label: 'Columns',
                            value: columns,
                            onChange: function (value) {
                                setAttributes({ columns: value });
                            },
                            min: 1,
                            max: 6
                        })
                    )
                ),
                el(
                    'div',
                    { className: 'custom-gallery-block-content' },
                    el(MediaUpload, {
                        onSelect: onSelectImages,
                        allowedTypes: ['image'],
                        multiple: true,
                        gallery: true,
                        value: images.map(function (img) { return img.id; }),
                        render: function (obj) {
                            return el(
                                'div',
                                {},
                                el(
                                    Button,
                                    {
                                        className: 'components-button is-primary',
                                        onClick: obj.open
                                    },
                                    images.length > 0 ? 'Edit Selection' : 'Select Images'
                                )
                            );
                        }
                    }),
                    el('div', { style: { marginTop: '15px' } }, renderGallery())
                )
            );
        },
        save: function () {
            return null; // Rendered in PHP
        }
    });
})(
    window.wp.blocks,
    window.wp.element,
    window.wp.blockEditor,
    window.wp.components
);
