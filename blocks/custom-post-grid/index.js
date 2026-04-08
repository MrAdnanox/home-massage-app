(function (blocks, element, blockEditor, components, data, serverSideRender) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;
    var useSelect = data.useSelect;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var SelectControl = components.SelectControl;
    var RangeControl = components.RangeControl;
    var ServerSideRender = serverSideRender; // Use the passed serverSideRender object
    var useBlockProps = blockEditor.useBlockProps;

    // Check if ServerSideRender is available
    if (!ServerSideRender) {
        console.error('ServerSideRender component not found.');
        return;
    }

    registerBlockType('mpe2025/custom-post-grid', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps();

            // Fetch Categories
            var categories = useSelect(function (select) {
                return select('core').getEntityRecords('taxonomy', 'category', { per_page: -1 });
            }, []);

            var categoryOptions = [{ label: 'All Categories', value: '' }];
            if (categories) {
                categories.forEach(function (category) {
                    categoryOptions.push({ label: category.name, value: category.id });
                });
            }

            return el(
                'div',
                blockProps,
                el(
                    InspectorControls,
                    {},
                    el(
                        PanelBody,
                        { title: 'Settings', initialOpen: true },
                        el(SelectControl, {
                            label: 'Post Type',
                            value: attributes.postType,
                            options: [
                                { label: 'Post', value: 'post' },
                                { label: 'Service', value: 'service' },
                                { label: 'Vehicle', value: 'vehicle' },
                                { label: 'Excursion', value: 'excursion' }
                            ],
                            onChange: function (value) {
                                setAttributes({ postType: value });
                            }
                        }),
                        el(SelectControl, {
                            label: 'Category',
                            value: attributes.selectedCategory,
                            options: categoryOptions,
                            onChange: function (value) {
                                setAttributes({ selectedCategory: value });
                            }
                        }),
                        el(RangeControl, {
                            label: 'Number of Posts',
                            value: attributes.postsToShow,
                            min: 1,
                            max: 12,
                            onChange: function (value) {
                                setAttributes({ postsToShow: value });
                            }
                        })
                    )
                ),
                el(ServerSideRender, {
                    block: 'mpe2025/custom-post-grid',
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
