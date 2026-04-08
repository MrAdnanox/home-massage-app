(function (blocks, element, blockEditor, components, data, serverSideRender) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var useBlockProps = blockEditor.useBlockProps;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var TextControl = components.TextControl;
    var ServerSideRender = serverSideRender; // Use the passed serverSideRender object

    registerBlockType('mpe2025/trust-indicators', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps();

            return el(
                'div',
                blockProps,
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Content', initialOpen: true },
                        el(TextControl, {
                            label: 'Experience Text',
                            value: attributes.experienceText,
                            onChange: function (value) {
                                setAttributes({ experienceText: value });
                            }
                        }),
                        el(TextControl, {
                            label: 'License Text',
                            value: attributes.licenseText,
                            onChange: function (value) {
                                setAttributes({ licenseText: value });
                            }
                        }),
                        el(TextControl, {
                            label: 'Reviews Text',
                            value: attributes.reviewsText,
                            onChange: function (value) {
                                setAttributes({ reviewsText: value });
                            }
                        })
                    )
                ),
                el(ServerSideRender, {
                    block: 'mpe2025/trust-indicators',
                    attributes: attributes
                })
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
    window.wp.components,
    window.wp.data,
    window.wp.serverSideRender
);
